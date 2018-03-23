<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Redirect;
use Route;
use Hash;

class UserSettingsController extends Controller
{
    /*
	This controller handles user personal settings, such as his name, known technologies, etc.
	*/

    public function index()
    {
        return view('user.settings.index', ['user' => Auth::user()]);
    }

    public function security()
    {
        return view('user.settings.security', ['user' => Auth::user()]);
    }

    public function integrations()
    {
        return view('user.settings.integrations');
    }

    public function update(Request $request)
    {
        $currentTab = explode('.', Route::current()->getName());

        if (!isset($currentTab[1])) { // 'profile' page
            $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'bio' => 'required|string|max:320'
                ]);

            if ($validator->fails()) {
                 return back()->withErrors($validator)->withInput();
            }

                $user = User::find(Auth::id());
                $user->name = $request->name;
                $user->bio = $request->bio;
                $user->save();

                // A redirect here is necessary, because Laravel updates its Auth::user() data every request,
                // so if we would just return a view here it would contain old (before update) data
                return Redirect::to('/settings')->with('message', 'Data successfully updated.');
        }

        switch ($currentTab[1]) {
            case 'security':
                $validator = Validator::make($request->all(), [
                    'password' => 'required|string',
                    'new_password' => 'required|string|confirmed'
                ]);

                if ($validator->fails()) {
                     return back()->withErrors($validator);
                }

                if (!Hash::check($request->password, Auth::user()['password'])) {
                    return back()->withErrors(array('password' => 'Password is incorrect!'));
                }
         
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->new_password);
                $user->save();

                return Redirect::to('/settings/security')->with('message', 'Password successfully changed.');
            break;
        }
    }
}
