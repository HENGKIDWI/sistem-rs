<?php

namespace App\Livewire\Tenant\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ManageUsers extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $userId, $name, $email, $password, $selectedRole;
    public $roles;
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
            'selectedRole' => 'required|string|exists:roles,name',
        ];
    }

    public function mount()
    {
        // Ambil role yang relevan untuk tenant, kecuali super_admin
        $this->roles = Role::where('name', '!=', 'super_admin')->pluck('name', 'name');
    }

    public function render()
    {
        $users = app('currentTenant')->users()->with('roles')->paginate(10);
        
        return view('livewire.tenant.admin.user.manage-users', [
            'users' => $users,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()->name ?? null;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->userId], $userData);

        // Lampirkan user ke tenant saat ini jika ini user baru
        if (!$this->userId) {
            app('currentTenant')->users()->attach($user->id);
        }
        
        // Sync role
        $user->syncRoles([$this->selectedRole]);

        session()->flash('message', $this->userId ? 'Pengguna berhasil diperbarui.' : 'Pengguna berhasil ditambahkan.');

        $this->closeModal();
    }

    public function delete($id)
    {
        // Kita tidak akan detach dari tenant, karena menghapus user akan menghapus relasinya juga
        User::find($id)->delete();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'selectedRole']);
    }
}
