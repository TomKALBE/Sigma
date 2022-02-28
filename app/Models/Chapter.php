<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable =[
        "title",
        "num",
        "formation_id"
    ];
    public function steps()
    {
        return $this->hasMany(Step::class,'chapter_id','id');
    }
}
