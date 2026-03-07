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
        'nama_lengkap',
        'email',
        'username',
        'password',
        'divisi',
        'status',
        'token_cuti',
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

    // relasi user memiliki banyak role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withTimestamps();
    }

    // Mengecek apakah user punya role tertentu (dipakai untuk auth & middleware)
    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return $this->roles()->whereIn('nama', $role)->exists();
        }

        return $this->roles()->where('nama', $role)->exists();
    }

    // Mengecek apakah user punya salah satu role
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('nama', $roles)->exists();
    }

    public function assignRole(array $roleIds): void
    {
        $roleIds = Role::whereIn('nama', $roleIds)->pluck('id')->toArray();
        $this->roles()->syncWithoutDetaching($roleIds);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'token_cuti' => 'integer',
        ];
    }

    public function perizinans()
    {
        return $this->hasMany(Perizinan::class);
    }
}
