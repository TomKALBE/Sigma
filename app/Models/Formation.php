<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = "formations";
    protected $fillable = [
        "id",
        "name",
        "type",
        "description",
        "picture",
        "price",
        "user_id"
    ];


    public function categories(){
        return $this->belongsToMany(Category::class,'formations_categories','formation_id','category_id');
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class,'formation_id','id')->orderBy('num','asc');
    }

}
