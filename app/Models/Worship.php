<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worship extends Model
{
    protected $fillable = [
        'student_id',
        'attendance',
        'worship_session_id',
        'name',
    ];

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function worshipSession()
{
    return $this->belongsTo(WorshipSession::class);
}

}
