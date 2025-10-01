<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifi extends Model
{
    use HasFactory;

    protected $table = 'notifis';

    protected $fillable = [
        'title',
        'image_url',
        'content',
        'author_name',
    ];
}
