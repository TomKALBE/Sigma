<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdatePicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        if (! Hash::check($request->old_password, Auth::user()->password))
        {
            return back()->withErrors([
                'old_password' => ['The provided password does not match our records.']
            ]);
        }
        if (Hash::check($request->password,Auth::user()->password))
        {
            return back()->withErrors([
                'password' => ['New password must be different than the old']
            ]);
        }
        Auth::user()->update(['password'=>Hash::make($request->password)]);
        return back()->with('success','Password changed !');
    }
    public function changePicture(UpdatePicture $request){

        $params = $request->validated();
        if(Storage::exists("public/".$params['picture'])){
            Storage::delete("public/".$params['picture']);
        }
        $file = Storage::put('public',$params['picture']);

        Auth::user()->update(['picture'=>substr($file,7)]);
        return back();
    }
    public function changeBpicture(UpdatePicture $request){

        $params = $request->validated();
        if(Storage::exists("public/".$params['picture'])){
            Storage::delete("public/".$params['picture']);
        }
        $file = Storage::put('public',$params['picture']);

        Auth::user()->update(['bpicture'=>substr($file,7)]);
        return back();
    }

    public function modifyInfo(ProfileRequest $request){
        $params = $request->validated();
        Auth::user()->update(['name'=>$params['first_name'],'last_name'=>$params['last_name'],'email'=>$params['email']]);
        return back();
    }
    public function modify(ProfileRequest $request,$id){
        $params = $request->validated();
        Auth::user()->where('id',$id)->update(['name'=>$params['first_name'],'last_name'=>$params['last_name'],'email'=>$params['email']]);
        return back();
    }
    public function delete(Request $request,$id){
        Auth::user()->where('id',$id)->delete();
        return back();
    }
}
