<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Rab extends Model
{
    protected $fillable = ['project_id', 'submitted_by', 'status', 'notes'];
    public function project() { return $this->belongsTo(Project::class); }
    public function submitter() { return $this->belongsTo(User::class, 'submitted_by'); }
    public function items() { return $this->hasMany(RabItem::class); }
}