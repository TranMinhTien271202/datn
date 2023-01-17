<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;

class RegisterController extends Controller
{
    //
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function getRegister()
    {
        return view('client.register.index');
    }

    public function postRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:candidates',
            'password' => 'required|min:6',
            'phone' => 'required|unique:candidates|digits:10',
            'gender' => 'required',
        ];
        $messages = [
            'name.required' => 'Mời bạn nhập vào tên',
            'email.required' => 'Mời bạn nhập vào email',
            'email.email' => 'Mời bạn nhập đúng định dạnh email',
            'email.unique' => 'Email bạn nhập đã tồn tại',
            'password.required' => 'Mời bạn nhập password',
            'password.min' => 'Mật khẩu yêu cầu tối thiểu 6 ký tự',
            'phone.required' => 'Mời bạn nhập vào số điện thoại',
            'phone.unique' => 'Số điện thoại bạn nhập đã tồn tại',
            'phone.digits' => 'Số điện thoại không tồn tại',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('candidate.register')->withErrors($validator)->withInput();
        } else {
            $users = new Candidate();
            $data = $request->only('name', 'email', 'phone', 'password', 'gender');
            $token = strtoupper(Str::random(10));
            $data['token'] = strtoupper(Str::random(10));
            $data['password'] = bcrypt($request->password);
            $data['status'] = 0;
            if ($candidate = Candidate::create($data)) {
                Mail::send('email.active-acc', compact('candidate'), function ($email) use ($candidate) {
                    $email->subject('UbWork - Xác nhận tài khoản');
                    $email->to($candidate->email, $candidate->name);
                });
            }
            if ($users == null) {
                return redirect()->route('candidate.register');
            } elseif ($users != null) {
                Session::flash('success', 'Đăng ký thành công');
                return redirect()->route('candidate.login');
            } else {
                Session::flash('error', 'Lỗi đăng ký');
                return redirect()->route('candidate.register');
            }
        }
    }
    public function actived(Candidate $candidate, $token)
    {
        if ($candidate->token === $token) {
            $candidate->update([
                'status' => 1,
                'verify_time' => Carbon::now(),
                'token' => null
            ]);
            return redirect()->route('candidate.login')->with('success', 'Kích Hoạt Tài Khoản Thành Công');
        } elseif ($candidate->token == null && $candidate->staus == 1) {
            return view('email.404');
        } else {
            return view('email.404');
        }
    }
    public function refresh()
    {
        return view('client.login.refresh-pass');
    }
    public function refreshPass(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:candidates',
        ], [
            'email.required' => 'Email không được để trống',
            'email.exists' => 'Email không tồn tại trên hệ thống'
        ]);
        $candidate = Candidate::where('email', $request->email)->first();
        $token = strtoupper(Str::random(10));
        $candidate->update([
            'token' => $token,
        ]);
        Mail::send('email.forget-pass', compact('candidate'), function ($email) use ($candidate) {
            $email->subject('UbWork - Lấy Lại Mật Khẩu');
            $email->to($candidate->email, $candidate->name);
        });
        return redirect()->route('candidate.login')->with('success', 'Vui Lòng Kiểm Tra Mail Để Thực Hiện Thay Đổi Mật Khẩu');
    }
    public function getPass()
    {
        return view('email.get-pass');
    }
    public function postPass(Candidate $candidate, Request $request)
    {
        if ($candidate->token === $request->token) {
            if ($request->password === $request->password2) {
                $candidate->update([
                    'token' => null,
                    'password' => bcrypt($request->password)

                ]);
                return redirect()->route('candidate.login')->with('success', 'Đổi mật khẩu thành công');
            } else {
                return back()->with('error','Mật khẩu không trùng khớp');
            }
        } else {
            return view('email.404');
        }
    }
}
