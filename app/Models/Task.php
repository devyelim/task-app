<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'due_date' => 'date',
    ];
}

