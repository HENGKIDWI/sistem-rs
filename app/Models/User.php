<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\RumahSakit;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notification_preferences' => 'array',
    ];

    /**
     * Mendefinisikan relasi one-to-one ke model Pasien.
     */
    public function pasien(): HasOne
    {
        return $this->hasOne(Pasien::class);
    }

    /**
     * Mendefinisikan relasi one-to-one ke model Dokter.
     */
    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class);
    }

    /**
     * Mendefinisikan relasi one-to-many ke model Appointment.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Accessor untuk mendapatkan URL foto profil.
     * Akan mengembalikan URL foto yang di-upload atau URL avatar default.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return Storage::disk('public')->url($this->profile_photo_path);
        }

        // Fallback ke UI Avatars jika tidak ada foto
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function rumahSakits()
    {
        return $this->belongsToMany(RumahSakit::class, 'rumah_sakit_user', 'user_id', 'rumah_sakit_id');
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->rumahSakits->contains($tenant);
    }
}
