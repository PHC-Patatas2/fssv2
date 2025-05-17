<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'subject_id', 'teacher_id', 'room_id', 'day', 'start_time', 'end_time', 'created_by', 'status'
    ];
    public function subject() { return $this->belongsTo(Subject::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
