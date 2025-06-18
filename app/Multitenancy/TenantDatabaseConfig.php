<?php

namespace App\Multitenancy;

use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class TenantDatabaseConfig implements SwitchTenantTask
{
    public function makeCurrent(IsTenant $tenant): void
    {
        config([
            'database.connections.tenant.database' => $tenant->database,
        ]);
    }

    public function forgetCurrent(): void
    {
        config([
            'database.connections.tenant.database' => null,
        ]);
    }
}
