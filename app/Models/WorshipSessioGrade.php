<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorshipSessionGrade extends Model
{
    protected $fillable = ['student_id', 'worship_session_id', 'grade'];

    public function session()
    {
        return $this->belongsTo(WorshipSession::class, 'worship_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
