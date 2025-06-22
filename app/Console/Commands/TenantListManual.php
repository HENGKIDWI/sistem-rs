<?php

namespace App\Console\Commands;

use App\Models\RumahSakit;
use Illuminate\Console\Command;
use function Laravel\Prompts\table;

class TenantListManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:list-manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menampilkan daftar semua tenant (rumah sakit) secara manual dari database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = RumahSakit::all(['id', 'name', 'domain']);

        if ($tenants->isEmpty()) {
            $this->warn('Tidak ada tenant (rumah sakit) yang ditemukan di database.');
            return;
        }

        // Menggunakan komponen tabel dari Laravel Prompts
        table(
            ['ID', 'Name', 'Domain'],
            $tenants->toArray()
        );
    }
}