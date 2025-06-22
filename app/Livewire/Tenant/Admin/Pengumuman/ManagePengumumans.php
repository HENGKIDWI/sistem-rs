<?php

namespace App\Livewire\Tenant\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithPagination;

class ManagePengumumans extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $pengumumanId, $judul, $isi, $tanggal;
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'nullable|date',
        ];
    }

    public function render()
    {
        $pengumumans = Pengumuman::where('tenant_id', app('currentTenant')->id)
            ->latest()
            ->paginate(10);
            
        return view('livewire.tenant.admin.pengumuman.manage-pengumumans', [
            'pengumumans' => $pengumumans,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $this->pengumumanId = $id;
        $this->judul = $pengumuman->judul;
        $this->isi = $pengumuman->isi;
        $this->tanggal = $pengumuman->tanggal ? \Carbon\Carbon::parse($pengumuman->tanggal)->format('Y-m-d') : null;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        Pengumuman::updateOrCreate(['id' => $this->pengumumanId], [
            'judul' => $this->judul,
            'isi' => $this->isi,
            'tanggal' => $this->tanggal,
            'tenant_id' => app('currentTenant')->id,
        ]);

        session()->flash('message', $this->pengumumanId ? 'Pengumuman berhasil diperbarui.' : 'Pengumuman berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Pengumuman::find($id)->delete();
        session()->flash('message', 'Pengumuman berhasil dihapus.');
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
        $this->pengumumanId = null;
        $this->judul = '';
        $this->isi = '';
        $this->tanggal = null;
    }
}
