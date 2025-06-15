<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignDefaultRole
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
    public function handle(Registered $event): void
    {
        // $event->user akan berisi data user yang baru saja mendaftar.
        $user = $event->user;

        // Berikan peran 'pasien' kepada user tersebut.
        $user->assignRole('pasien');
    }
}