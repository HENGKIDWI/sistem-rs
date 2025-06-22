<?php

namespace App\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class ApplyTenantScopeTask implements SwitchTenantTask
{
    public function makeCurrent(Tenant $tenant): void
    {
        /**
         * "Scope" ini akan diterapkan ke SEMUA query Eloquent.
         * Ia akan secara otomatis menambahkan `WHERE tenant_id = {id_tenant_aktif}`
         * pada setiap query ke model yang memiliki kolom 'tenant_id'.
         */
        Model::addGlobalScope('tenant', function (Builder $builder) use ($tenant) {
            // Cek dulu apakah model punya kolom 'tenant_id' sebelum menerapkan scope
            if (Schema::hasColumn($builder->getModel()->getTable(), 'tenant_id')) {
                 $builder->where('tenant_id', $tenant->getKey());
            }
        });
    }

    public function forgetCurrent(): void
    {
        // Menghapus scope saat tidak ada tenant yang aktif.
        Model::removeGlobalScope('tenant');
    }
}