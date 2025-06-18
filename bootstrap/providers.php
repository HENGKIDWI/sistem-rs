<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\SuperAdminPanelProvider::class,
    App\Providers\EventServiceProvider::class,
    Spatie\Multitenancy\MultitenancyServiceProvider::class, // <-- TAMBAHKAN BARIS INI
];