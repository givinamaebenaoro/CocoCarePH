<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ecotrack extends Model
{

    protected $fillable = [
        'user_id', 'name', 'task_name', 'task_description', 'status', 'last_completed_date', 'consecutive_days'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
