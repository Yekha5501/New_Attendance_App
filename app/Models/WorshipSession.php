<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorshipSession extends Model
{
    protected $fillable = ['date','title','type','status','time_created'];

    public function attendance()
    {
        return $this->hasMany(WorshipSessionAttendance::class);
    }

    public function worships()
{
    return $this->hasMany(Worship::class);
}

}
