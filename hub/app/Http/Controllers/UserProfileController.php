<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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

    public function follow ($username)
    {
    	$user = User::where('username', $username)->firstOrFail();
    	if (Auth::user()->follow($user))
    		return response()->json([
    			'status' => 'success'
    		]);

    	return response()->json([
    		'status' => 'error'
    	]);
    }

    public function unfollow ($username)
    {
    	$user = User::where('username', $username)->firstOrFail();
    	if (Auth::user()->unfollow($user))
    		return response()->json([
    			'status' => 'success'
    		]);

    	return response()->json([
    		'status' => 'error'
    	]);
    }
}
