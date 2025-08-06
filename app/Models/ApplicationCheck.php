<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationCheck extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'user_id',
        'status',
        'checked_at',
        'comment',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
