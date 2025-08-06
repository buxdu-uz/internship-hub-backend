<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEnterprise extends Model
{
    protected $fillable = [
        'user_id',
        'enterprise_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
