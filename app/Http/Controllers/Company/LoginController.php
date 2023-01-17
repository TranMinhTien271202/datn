<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function getLogin()
    {
        if (auth('company')->check()) {
            Session::flash('error', 'Tài khoản đã login');
            return redirect()->route('company.home');
        }
        return view('company.login.index');
    }
    public function postLogin(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $message = [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng!',
            'password.required' => 'Vui lòng nhập mật khẩu'

        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect('company/login')->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
            if (auth('company')->attempt(['email'=>$email, 'password'=>$password])){
                $data = auth('company')->user();
                if($data->status != 0 || $data->status != 2){
                    auth('company')->login($data);
                    return redirect('company/dashboard');
                }else{
                    auth('company')->logout();
                    Session::flash('error', 'Tài khoản chưa được kích hoạt vui lòng kích hoạt tài khoản!');
                    return redirect()->back()->withInput();
                }
            } else {
                Session::flash('error', 'Email hoặc mật khẩu không đúng');
                return redirect()->back()->withInput();
            }
        }
    }
    public function logOut(Request $request){
        auth('company')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('company.login');
    }
}
