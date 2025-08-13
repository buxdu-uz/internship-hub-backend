<?php

namespace App\Models;

use App\Models\Enterprise;
use App\Models\User;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'enterprise_id',
        'teacher_id',
        'direction',
        'start_at',
        'end_at',
        'date',
        'reason',
        'plan',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => 'string',
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function checkApplication()
    {
        return $this->hasOne(ApplicationCheck::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
