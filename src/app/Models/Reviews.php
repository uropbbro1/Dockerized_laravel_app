<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'text',
        'is_recommended',
        'created_at',
        'updated_at'
    ];


    public $timestamps = true;
}
