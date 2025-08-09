<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'user';

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'role',
        'pharmacy_id',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Only allow pharmacy owners to access admin panel
        return $this->role === 'PHARMACY_OWNER';
    }

    public function getFilamentName(): string
    {
        Log::debug('Username:', ['username' => $this->username]);
        Log::debug('Email:', ['email' => $this->email]);

        return $this->username ?? $this->email ?? 'Fallback';
    }
}
