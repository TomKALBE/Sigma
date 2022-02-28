<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(CategoryRequest $request){
        $param = $request->validated();

        $category = new Category($param);
        $category->save();
        return back();
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return back();
    }
    public function modify(CategoryRequest $request,$id)
    {
        Category::where('id',$id)->update(['name'=>$request->name]);
        return back();
    }
}
