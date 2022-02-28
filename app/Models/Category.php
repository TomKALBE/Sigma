<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable =[
        "name"
    ];
    public function formations(){
        return $this->belongsToMany(Formation::class,'formations_categories','category_id','formation_id');
    }
}
