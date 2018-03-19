<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WallController extends Controller
{
    /* 
    * This is a controller which handles the Wall. Wall is a main page, where you can see all of your friend's 
	* newest activity.
	*/

	public function index () 
	{
		return view('wall');
	}
}
