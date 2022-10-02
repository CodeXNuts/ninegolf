<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     function __construct()
     {
        $this->middleware('auth:administrator');
     }
    public function index()
    {
        $allActive = User::where(['is_active'=>true])->orderBy('id','DESC')->get();
        return view('administrator.user.index',['users'=>$allActive]);

    }
}
