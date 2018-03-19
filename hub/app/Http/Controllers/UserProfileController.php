<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserProfileController extends Controller
{
    /*
    This controller handles user's profiles
    */

    public function index ($username)
    {
    	$user = User::where('username', $username)->firstOrFail();
    	return view('user.profile', ['user' => $user]);
    }
}
