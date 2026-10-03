<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'link',
        'type',
        'created_by',
        'periode_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'parent_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
}
