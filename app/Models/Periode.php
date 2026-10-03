<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $fillable = [
        'name',
        'year_start',
        'year_end',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the currently active periode.
     */
    public static function active(): ?static
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Activate this periode and deactivate all others.
     */
    public function activate(): void
    {
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function kasDanuses(): HasMany
    {
        return $this->hasMany(KasDanus::class);
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
