<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorshipSessionAttendance extends Model
{
    protected $fillable = ['worship_session_id', 'student_id', 'attended'];

    public function session()
    {
        return $this->belongsTo(WorshipSession::class, 'worship_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}


