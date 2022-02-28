<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(RegisterRequest $request)
    {
        $params['email'] = $request->email;
        $params['token'] = (string) Str::uuid();
        Mail::to('admin@test.com')->send(new ContactMail($params));
        return back();
    }
}
