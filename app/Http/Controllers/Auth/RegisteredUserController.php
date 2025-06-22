<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form registrasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'digits:16', 'unique:pasiens,nik'], // Tambahkan validasi NIK
            'tanggal_lahir' => ['required', 'date'], // Tambahkan validasi Tanggal Lahir
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'], // Tambahkan validasi Jenis Kelamin
            'nomor_telepon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        try {
            // 2. Gunakan transaction untuk memastikan data user dan pasien dibuat bersamaan
            $user = DB::transaction(function () use ($request) {
                // Buat data user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Assign the 'pasien' role to the new user
                $pasienRole = Role::findByName('pasien');
                if ($pasienRole) {
                    $user->assignRole($pasienRole);
                }

                // Buat data pasien yang terhubung
                Pasien::create([
                    'user_id'           => $user->id,
                    'nik'               => $request->nik,
                    'nama'              => $request->name, // PASTIKAN KUNCI INI 'nama', BUKAN 'nama_lengkap'
                    'nomor_rekam_medis' => 'RM-' . date('Ymd') . '-' . $user->id, // PASTIKAN KUNCI INI 'nomor_rekam_medis'
                    'tanggal_lahir'     => $request->tanggal_lahir,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'alamat'            => $request->alamat,
                    'nomor_telepon'     => $request->nomor_telepon // PASTIKAN KUNCI INI 'nomor_telepon'
                ]);

                return $user;
            });

            // 3. Trigger event bahwa user telah terdaftar
            event(new Registered($user));

            // 4. Login user yang baru dibuat
            Auth::login($user);

            // 5. Redirect ke halaman yang dituju (biasanya dashboard)
            return redirect(RouteServiceProvider::HOME);

        } catch (\Exception $e) {
            dd($e); 
            // Jika terjadi error, catat log dan kembalikan ke halaman registrasi
            \Log::error('Registration Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.')->withInput();
        }
    }
}
