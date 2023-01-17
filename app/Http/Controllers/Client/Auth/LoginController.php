<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Candidate;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

    public function getLogin($job_id = null)
    {
        if (!empty($job_id)) {
            Session::flash('job_id', $job_id);
        }
        
        if (auth('candidate')->check()) {
            Session::flash(__('Account is logged in'));
            return Redirect::to('/');
        }
        if (session('link')) {
            $myPath     = session('link');
            $loginPath  = url('/login');
            $previous   = url()->previous();
    
            if ($previous = $loginPath) {
                session(['link' => $myPath]);
            }
            else{
                session(['link' => $previous]);
            }
        }
        else{
             session(['link' => url()->previous()]);
        }
        return view('client.login.login');
    }

    public function postLogin(AuthRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (auth('candidate')->attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            $data = auth('candidate')->user();
            auth('candidate')->login($data);
            Session::flash('success', 'Đăng nhập thành công');
            if (Session::has('job_id') ) {
                return redirect(session('link')); 
                return redirect()->route('job-detail',Session::get('job_id'));
            }else{
                return redirect(session('link')); 
                return redirect()->back();
            }
        } elseif (auth('candidate')->attempt(['email' => $email, 'password' => $password, 'status' => 0])) {
            auth('candidate')->logout();
            Session::flash('error', 'Tài Khoản Của bạn chưa được kích hoạt. Vui lòng kích hoạt tài khoản');
            return redirect(session('link')); 
        } else {
            Session::flash('error', 'Email hoặc mật khẩu không đúng');
            return Redirect::to('/login');
        }
    }
    public function logout()
    {
        if (auth('candidate')->check()) {
            auth('candidate')->logout();
            return Redirect::to('/login');
        }
    }
}
