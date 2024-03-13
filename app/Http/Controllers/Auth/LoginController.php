<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\IsActive;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    //
    public function index()
    {
        //
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $remember_me = !is_null($request->remember_me) ? true : false;
        $credentialsOnly = $request->validate([
            'email'    => ['required','email:dns','exists:users,email,deleted_at,NULL',new IsActive],
            'password' => ['required','min:8'],
        ]);

        $user = User::where('email',$request->email)->first();
        if($user){
            if (Auth::attempt($credentialsOnly, $remember_me))
            {
                return redirect()->route('dashboard')->with(['success' => true,
                'message' => trans('quickadmin.qa_login_success'),
                'title'=> trans('quickadmin.qa_login'),
                'alert-type'=> trans('quickadmin.alert-type.success')]);
            }

            return redirect()->route('login')->withErrors(['wrongcrendials' => trans('auth.failed')])->withInput($request->only('email', 'password'));

        }else{
            return redirect()->route('login')->withErrors(['email' => trans('quickadmin.qa_invalid_username')])->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

}
