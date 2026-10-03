<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'tujuan',
        'sasaran',
        'modal',
        'pendapatan',
        'catatan_evaluasi',
        'category',
        'target_amount',
        'status',
        'start_date',
        'end_date',
        'created_by',
        'periode_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'target_amount' => 'decimal:2',
        'modal' => 'decimal:2',
        'pendapatan' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function finances(): HasMany
    {
        return $this->hasMany(ProjectFinance::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (empty($attributes['start_date'])) {
                    return 'planning';
                }

                $today = Carbon::today();
                $start = Carbon::parse($attributes['start_date'])->startOfDay();
                $end = empty($attributes['end_date']) ? null : Carbon::parse($attributes['end_date'])->endOfDay();

                if ($today->lt($start)) {
                    return 'planning';
                }

                if ($end && $today->gt($end)) {
                    return 'completed';
                }

                return 'active';
            }
        );
    }
}
