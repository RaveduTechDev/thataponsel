<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nomor_wa',
        'toko_cabang_id',
        'jumlah_transaksi',
        'username',
        'password',
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
        ];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    protected $with = ['tokoCabang', 'roles'];

    public function tokoCabang()
    {
        return $this->belongsTo(TokoCabang::class)->select('id', 'nama_toko_cabang', 'alamat_toko');
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function jasaImei()
    {
        return $this->hasMany(JasaImei::class);
    }

    public function scopeIsAgent()
    {
        return $this->whereHas('roles', function ($query) {
            $query->where('name', 'agen');
        });
    }

    public function scopeIsAdmin()
    {
        return $this->whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        });
    }

    public function scopeIsAgentAdmin()
    {
        return $this->whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'agen']);
        });
    }

    public function scopeNonSuperAdmin()
    {
        return $this->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        });
    }

    public function scopeRoleLogin($query, $role)
    {
        if ($role == 'owner') {
            return $query->whereHas('roles', function ($q) {
                $q->whereIn('name', ['admin', 'agen']);
            });
        }

        if ($role == 'admin') {
            return $query->whereHas('roles', function ($q) {
                $q->where('name', 'agen');
            });
        }

        return $query;
    }

    public function getNomorWaAgentFormattedAttribute(): string
    {
        try {
            return phone($this->attributes['nomor_wa'], 'ZZ', \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return $this->attributes['nomor_wa'];
        }
    }

    public function shortName(): string
    {
        $parts = preg_split('/\s+/', trim($this->attributes['name']));
        if (count($parts) <= 2) {
            $name = $this->attributes['name'];
        } else {
            $firstName = array_shift($parts);
            $lastName = array_pop($parts);
            $name = $firstName . ' ' . $lastName;
        }

        return strlen($name) > 17 ? substr($name, 0, 15) . '...' : $name;
    }

    public function shortUsername(): string
    {
        return strlen($this->attributes['username']) > 20 ? substr($this->attributes['username'], 0, 17) . '...' : $this->attributes['username'];
    }
}
