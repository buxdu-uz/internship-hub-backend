<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'surname',
        'phone',
        'sex',
        'birth',
        'organization',
        'bio',
    ];
}
