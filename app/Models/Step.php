<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
      'name',
      'content',
      'chapter_id',
        'num'
    ];
}
