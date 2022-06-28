<?php

namespace App\Http\Controllers;

use App\Models\produtos;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show(user $user)
    {
        return view('user',[
            'id'=>$user->all()
        ]);
    }

}
