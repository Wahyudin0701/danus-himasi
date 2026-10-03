<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'link',
        'type',
        'created_by',
    ];

    public function parent()
    {
        return $this->belongsTo(Dokumen::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Dokumen::class, 'parent_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}