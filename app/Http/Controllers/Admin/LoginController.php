<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            Session::flash('Account is logged in');
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login.index');
    }
    public function postLogin(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $message = [
            'email.required' => 'Email bắt buộc nhập!',
            'email.email' => 'Email không đúng định dạng!',
            'password.required' => 'Mật khẩu bắt buộc nhập!'

        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect('admin/login')->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
            if (Auth::attempt(['email'=>$email, 'password'=>$password])){
                return redirect('admin');
            } else {
                Session::flash('error', 'Email hoặc mật khẩu không đúng');
                return redirect('admin/login')->withInput();
            }
        }

    }

    public function getLogOut(){
        Auth::logout();
        return redirect('admin/login');
    }
}
