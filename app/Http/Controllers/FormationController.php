<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormationRequest;
use App\Models\Chapter;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
{
    public function index($id)
    {
        $formation = Formation::find($id);

        return view('formation',compact('formation'));
    }

    public function add(FormationRequest $request)
    {
        $params = $request->validated();
        $file = Storage::put('public',$params['picture']);
        $params['picture'] = substr($file,7);
        $params['user_id'] = Auth::id();
        $formation = Formation::create($params);
        if (!empty($params['categories'])){
            $formation->categories()->attach($params['categories']);
        }
        $formation->save();
        return back();
    }

    public function edit($id)
    {

        $formation = Formation::find($id);
        if(Auth::user()->id !== $formation->user_id && Auth::user()->role == 'formator')
            return back()->with('error','Access denied');

        return view('create',compact('formation'));
    }
}
