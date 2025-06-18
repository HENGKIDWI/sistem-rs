<?php

namespace App\Listeners;

// ↓↓↓ Pastikan baris ini ada dan tidak salah ketik ↓↓↓
use Spatie\Multitenancy\Events\TenantCreated;
use Illuminate\Support\Facades\Artisan;

class RunTenantMigrations
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
public function handle(TenantCreated $event): void
{
    Artisan::call('tenants:artisan', [
        'artisanCommand' => 'migrate --database=tenant --seed --force',
        '--tenant' => $event->tenant->id,
    ]);
}

}