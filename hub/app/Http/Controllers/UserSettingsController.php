<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Redirect;

class UserSettingsController extends Controller
{
	/*
	This controller handles user personal settings, such as his name, known technologies, etc.
	*/

    public function index ()
    {
    	return view('user.settings', ['user' => Auth::user()]);
    }

    public function update (Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|string|max:255'
    	]);

    	if ($validator->fails())
    		 return back()->withErrors($validator)->withInput();

    	$user = User::find(Auth::id());
    	$user->name = $request->name;
    	$user->save();

    	// A redirect here is necessary, because Laravel updates its Auth::user() data every request,
    	// so if we would just return a view here it would contain old (before update) data
    	return Redirect::to('/settings')->with('message', 'Data successfully updated.');
    }
}
