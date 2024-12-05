<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'First_name',
        'Surname',
        'registration_number',
        'email',
        'phone_number',
        'gender',
        'status',
        'avg_grade',
        'qrcode_path',
        'program_of_study',
    ];

    // You can define relationships, such as attendance records, here
    // For example, if a student has many attendance records
   
}
