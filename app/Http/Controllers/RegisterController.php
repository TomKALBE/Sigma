<?php

namespace App\Http\Controllers;

use App\Mail\AcceptedMail;
use App\Mail\RefusedMail;
use App\Models\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function add($id)
    {
        $register = Register::where("token",$id)->first();

        if ($register->tokenUsed == true){
            return view('auth.accepted')->withErrors(['updated_at'=>$register->updated_at->toDateTimeString()]);
        }

        Register::where("token",$id)->update(['tokenUsed'=>true]);
        $params['email'] = $register->email;
        $params['token'] = $register->token;
        User::create([
            'name' => 'default',
            'last_name' => 'default',
            'email' => $register->email,
            'password' => Hash::make($register->token),
        ]);


        Mail::to($register->email)->send(new AcceptedMail($params));
        return view('auth.accepted')->with(['email'=>$register->email]);
    }

    public function refuse($id)
    {
        $register = Register::where("token",$id)->first();

        if ($register->tokenUsed == true){
            return view('auth.refused')->withErrors(['updated_at'=>$register->updated_at->toDateTimeString()]);
        }

        Register::where("token",$id)->update(['tokenUsed'=>true]);
        $params['email'] = $register->email;
        $params['token'] = $register->token;
        User::create([
            'name' => 'default',
            'last_name' => 'default',
            'email' => $register->email,
            'password' => Hash::make($register->token.'efefz'),
        ]);
        Mail::to($register->email)->send(new RefusedMail($params));
        return view('auth.refused')->with(['email'=>$register->email]);
    }

}
