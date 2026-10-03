<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProjectFinance extends Model
{
    protected $fillable = ['project_id', 'type', 'description', 'amount', 'date', 'created_by'];
    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];
    public function project() { return $this->belongsTo(Project::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}