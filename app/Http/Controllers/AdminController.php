<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $formations = Formation::when($request->term, function ($query, $term) {
            return $query->where('name', 'like', "%{$term}%");
        })->when($request->price && in_array($request->price, ['more-expensive', 'less-expensive']), function ($query) use ($request) {
            return $query->orderBy('price', $request->price == 'less-expensive' ? 'asc' : 'desc');
        })->when($request->term, function ($query, $term) {
            return $query->where('name', 'like', "%{$term}%");
        })->paginate(9)->appends(request()->query());
        $categories = Category::all();
        return view('admin',compact('formations','categories'));
    }
}
