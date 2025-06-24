<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_completed'];

    public $timestamps = false; // since only created_at exists

    protected $casts = [
        'is_completed' => 'boolean',
        'created_at' => 'datetime',
    ];
}
