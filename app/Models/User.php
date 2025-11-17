<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ad','soyad','tc_kimlik_no','dogum_tarihi','cinsiyet','telefon','telefon_ikinci','adres','il','ilce','mahalle','profil_resmi','mezun_oldugu_okul','statu','brans','birim','yetki_seviyesi','is_giris_tarihi','isten_ayrilma_tarihi','aktif','acil_durum_kisisi_adi','acil_durum_kisisi_telefon','acil_durum_kisisi_yakinlik','notlar','saglik_engeli_varmi','saglik_raporu','engel_aciklama'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dogum_tarihi' => 'date',
            'is_giris_tarihi' => 'date',
            'isten_ayrilma_tarihi' => 'date',
            'aktif' => 'boolean',
            'saglik_engeli_varmi' => 'boolean',
        ];
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group', 'user_id', 'grup_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'rol_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_project')->withPivot('gorev','atanma_tarihi');
    }

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class, 'user_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('rol_adi', $role)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        // check direct roles' permissions
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('izin_adi', $permission)->exists()) {
                return true;
            }
        }
        return false;
    }

    public function personnelFiles()
    {
        return $this->hasMany(PersonnelFile::class, 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }
}
