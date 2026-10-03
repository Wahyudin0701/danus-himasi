<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasDanus extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'date',
        'type',
        'amount',
        'description',
        'periode_id',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
}
