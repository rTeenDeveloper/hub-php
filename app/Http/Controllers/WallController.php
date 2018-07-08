<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use Auth;

class WallController extends Controller
{
    /*
    * This is a controller which handles the Wall. Wall is a main page, where you can see all of your friend's 
	* newest activity.
	*/

    public function index()
    {
        return view('wall', array('entries' => Entry::all()));
    }

    public function store (Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required',
        ]);

        $entry = new Entry;
        $entry->body = $request->body;
        $entry->user_id = Auth::user()->id;
        $entry->save();
        return $this->index();
    }
}
