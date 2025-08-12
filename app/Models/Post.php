<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//adding has factory trait
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    // use HasFactory
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];
}
