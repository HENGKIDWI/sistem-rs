<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Spatie\Multitenancy\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class ForceTenantAssetUrl
{
    /**
     * Handle an incoming request.
     * Middleware ini akan secara dinamis mengatur URL utama aplikasi
     * berdasarkan domain tenant yang sedang diakses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Menggunakan fitur dari paket Spatie untuk mendapatkan tenant saat ini.
        if ($tenant = Tenant::current()) {
            
            // Dapatkan domain dari data tenant (misal: "rs-sehat.rumahsakit.test").
            $tenantDomain = $tenant->domain;

            // Bangun URL root yang benar, termasuk skema (http) dan port.
            // Ini akan menghasilkan URL seperti "http://rs-sehat.rumahsakit.test:8000".
            $tenantRootUrl = $request->getScheme() . "://" . $tenantDomain . ":" . $request->getPort();

            // Ini adalah bagian terpenting:
            // Memaksa Laravel untuk menggunakan URL tenant ini saat membuat URL apa pun (misal: foto profil).
            URL::forceRootUrl($tenantRootUrl);
        }

        // Lanjutkan request ke tujuan berikutnya (middleware lain atau controller).
        return $next($request);
    }
}
