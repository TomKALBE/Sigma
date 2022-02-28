<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    public function index(){
        $categories = Category::all();
        $registerRequests = Register::all()->sortByDesc('created_at');
        $users = User::all()->where('role','!=','admin');
        return view('manage',compact(['categories','registerRequests','users']));
    }
}
