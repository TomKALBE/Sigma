<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeEditRequest;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request){
//        $annonces = Annonce::when($request->term, function ($query, $term) {
//            return $query->where('title', 'like', "%{$term}%");
//        })->when($request->categorie, function ($query, $categorie) {
//            return $query->where('categorie', 'like', "%{$categorie}%");
//        })->when($request->price && in_array($request->price, ['more-expensive', 'less-expensive']), function ($query) use ($request) {
//            return $query->orderBy('price', $request->price == 'less-expensive' ? 'asc' : 'desc');
//        }, function ($query) {
//            return $query->orderByDesc('id');
//        })->paginate(15);

        $formations = Formation::when($request->term, function ($query, $term) {
            return $query->where('name', 'like', "%{$term}%");
        })->when($request->price && in_array($request->price, ['more-expensive', 'less-expensive']), function ($query) use ($request) {
            return $query->orderBy('price', $request->price == 'less-expensive' ? 'asc' : 'desc');
        })->paginate(9)->appends(request()->query());

        $categories = Category::all();
        return view('landing',compact('formations','categories'));
    }
    public function test()
    {
        $formations = Formation::where('user_id', Auth::id())->get();
        return view('test',compact('formations'));
    }
    public function home()
    {
        $formations = Formation::where('user_id', Auth::id())->paginate(4)->appends(request()->query());
        $categories = Category::all();
        return view('home',compact('formations','categories'));
    }
    public function edit(HomeEditRequest $request,$id)
    {
        $params = $request->validated();
        $formation = Formation::find($id);

        if (empty($request->picture))
            $formation->update([
                "name"=>$request->name,
                "description"=>$request->description,
                "price"=>$request->price,
                "type"=>$request->type,
            ]);
        else {
            $formation->update([
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "type" => $request->type,
                "picture" => $request->picture

            ]);
            if(Storage::exists("public/$request->picture")){
                Storage::delete("public/$request->picture");
            }

            $file = Storage::put('public',$request['picture']);
            $formation->picture = substr($file,7);
        }
        $formation->categories()->detach();
        if (!empty($params['categories'])){
            $formation->categories()->attach($params['categories']);
        }
        $formation->save();

        return back();
    }
    public function delete($id){
        $formation = Formation::find($id);
        if(Storage::exists("public/$formation->picture")){
            Storage::delete("public/$formation->picture");
        }
        $formation->delete();
        return back();
    }
}
