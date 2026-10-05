<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nim',
        'password',
        'role',
        'bidang_id',
        'angkatan',
        'jabatan',
        'photo',
        'periode_id',
        'last_read_message_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
}
