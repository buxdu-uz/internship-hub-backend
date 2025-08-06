<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'code',
        'name',
        'api_url',
        'student_url',
        'employee_url'
    ];
}
