<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'worship_session_id',
        'student_id',
    ];

    /**
     * Get the user that owns the scan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    /**
     * Get the scans count.
     */
public function getScansCountAttribute()
    {
        return $this->scans()->count();
    }
    /**
     * Get the worship session that owns the scan.
     */
    public function worshipSession()
    {
        return $this->belongsTo(WorshipSession::class);
    }

    /**
     * Get the student that owns the scan.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}



