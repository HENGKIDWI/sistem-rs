<?php

namespace App\Livewire\Tenant\Admin\Dokter;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class ManageDokters extends Component
{
    use WithPagination, WithFileUploads;

    public $isModalOpen = false;
    public $dokterId, $userId;
    public $nama_lengkap, $spesialisasi, $nomor_str, $email, $password, $status;
    public $foto;

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'nomor_str' => ['required', 'string', Rule::unique('dokters')->ignore($this->dokterId)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'password' => $this->dokterId
                ? ['nullable', 'string', 'min:8']
                : ['required', 'string', 'min:8'],
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ];
    }

    public function render()
    {
        $dokters = Dokter::where('tenant_id', app('currentTenant')->id)
            ->with('user')
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.tenant.admin.dokter.manage-dokters', [
            'dokters' => $dokters,
        ])->layout('layouts.app', [
            'header' => 'Manajemen Dokter'
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->dokterId = null;
        $this->userId = null;
        $this->nama_lengkap = '';
        $this->spesialisasi = '';
        $this->nomor_str = '';
        $this->email = '';
        $this->password = '';
        $this->status = 'aktif';
        $this->foto = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        \DB::transaction(function () {
            if ($this->userId) {
                // Update User
                $user = User::find($this->userId);
                $user->update([
                    'name' => $this->nama_lengkap,
                    'email' => $this->email,
                ]);
                if ($this->password) {
                    $user->update(['password' => Hash::make($this->password)]);
                }
            } else {
                // Create User
                $user = User::create([
                    'name' => $this->nama_lengkap,
                    'email' => $this->email,
                    'password' => Hash::make($this->password ?: 'password'),
                ]);
                $user->assignRole('dokter');
            }

            // Create or Update Dokter
            $dokter = Dokter::updateOrCreate(['id' => $this->dokterId], [
                'user_id' => $user->id,
                'tenant_id' => app('currentTenant')->id,
                'nama_lengkap' => $this->nama_lengkap,
                'spesialisasi' => $this->spesialisasi,
                'nomor_str' => $this->nomor_str,
                'status' => $this->status,
            ]);

            if ($this->foto) {
                // Hapus foto lama jika ada dan sedang update
                if ($this->dokterId && $dokter->foto_path) {
                    \Storage::disk('public')->delete($dokter->foto_path);
                }
                $dokter->foto_path = $this->foto->store('foto-dokter', 'public');
                $dokter->save();
            }
        });

        session()->flash('message', $this->dokterId ? 'Data Dokter Berhasil Diperbarui.' : 'Dokter Baru Berhasil Ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        $this->dokterId = $id;
        $this->userId = $dokter->user_id;
        $this->nama_lengkap = $dokter->nama_lengkap;
        $this->spesialisasi = $dokter->spesialisasi;
        $this->nomor_str = $dokter->nomor_str;
        $this->email = $dokter->user->email;
        $this->status = $dokter->status;
        $this->password = '';
        $this->foto = null;

        $this->openModal();
    }

    public function delete($id)
    {
        $dokter = Dokter::find($id);
        if($dokter && $dokter->user) {
            $dokter->user->delete(); // Hapus user terkait
        }
        $dokter->delete();
        session()->flash('message', 'Data Dokter Berhasil Dihapus.');
    }
}
