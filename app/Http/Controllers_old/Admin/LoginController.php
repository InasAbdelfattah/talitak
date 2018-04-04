<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function __construct()
    {


    }

    /**
     * @return string
     * @@ return login view
     * @@ access file login.blade.php from views.admin.login
     */


    public function login()
    {

        if (auth()->check() && auth()->user()->hasAnyRoles()) {
            return redirect(route('admin.home'));
            // return view('admin.auth.login');
        }
        return view('admin.auth.login');
    }


    public function postLogin(Request $request)
    {


        //return $request->all();
        $this->validate($request, [
            'provider' => 'required',
            'password' => 'required'
        ]);

        $field = filter_var($request->provider, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


        if (Auth::attempt([$field => $request->provider, 'password' => $request->password])) {

            return redirect()->route('admin.home');
        }

        session()->flash('error', 'اسم المستخدم او كلمة المرور غير صحيح');
        return redirect()->back()->withInput();


    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route('admin.login'));

    }

}
