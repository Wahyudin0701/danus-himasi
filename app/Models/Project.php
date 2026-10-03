<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'target_amount' => 'decimal:2',
        'modal' => 'decimal:2',
        'pendapatan' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function finances()
    {
        return $this->hasMany(ProjectFinance::class);
    }
}