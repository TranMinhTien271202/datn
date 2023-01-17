<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;

class RegisterController extends Controller
{
    public function getRegister()
    {
        return view('company.register.index');
    }
    public function postRegister(Request $request)
    {
        $rules = [
            'company_name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:companies',
            'password' => 'required|string|min:6',
            'phone' => 'required|digits:10|unique:companies',
        ];
        $messages = [
            'company_name.required' => 'Mời bạn nhập vào tên',
            'phone.digits' => 'Số điện thoại không tồn tại',
            'email.required' => 'Mời bạn nhập vào email',
            'email.email' => 'Mời bạn nhập đúng định dạnh email',
            'email.unique' => 'Email bạn nhập đã tồn tại',
            'password.required' => 'Mời bạn nhập password',
            'password.min' => 'Mật khẩu yêu cầu tối thiểu 6 ký tự',
            'phone.required' => 'Mời bạn nhập vào số điện thoại',
            'phone.unique' => 'Số điện thoại bạn nhập đã tồn tại',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('company.register')->withErrors($validator);
        } else {
            $users = new Company();
            $data = $request->only('company_name', 'email', 'phone', 'password', 'gender');
            $token = strtoupper(Str::random(10));
            $data['token'] = strtoupper(Str::random(10));
            $data['password'] = bcrypt($request->password);
            $data['status'] = 0;
            if ($candidate = Company::create($data)) {
                Mail::send('company.email.active-acc', compact('candidate'), function ($email) use ($candidate) {
                    $email->subject('UbWork - Xác nhận tài khoản');
                    $email->to($candidate->email, $candidate->company_name);
                });
            }
            if ($users == null) {
                return redirect()->route('company.register');
            } elseif ($users != null) {
                Session::flash('success', 'Đăng ký thành công vui lòng kiểm tra email để kích hoạt tài khoản!');
                return redirect()->route('company.login');
            } else {
                Session::flash('error', 'Lỗi đăng ký');
                return redirect()->route('company.register');
            }
            return redirect()->route('company.login');
        }
    }
    public function activeCompany(Company $candidate, $token)
    {
        if ($candidate->token === $token) {
            $candidate->update([
                'status' => 3,
                'verify_time' => Carbon::now(),
                'token' => null
            ]);
            return redirect()->route('company.login')->with('success', 'Kích Hoạt Tài Khoản Thành Công');
        } elseif ($candidate->token == null && $candidate->staus != 0) {
            return view('email.404');
        } else {
            return view('email.404');
        }
    }
    public function PassCompany()
    {
        return view('company.email.refresh-pass');
    }
    public function PassCompanies(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:candidates',
        ], [
            'email.required' => 'Email không được để trống',
            'email.exists' => 'Email không tồn tại trên hệ thống'
        ]);
        $candidate = Company::where('email', $request->email)->first();
        $token = strtoupper(Str::random(10));
        $candidate->update([
            'token' => $token,
        ]);
        Mail::send('company.email.forget-pass', compact('candidate'), function ($email) use ($candidate) {
            $email->subject('UbWork - Lấy Lại Mật Khẩu');
            $email->to($candidate->email, $candidate->name);
        });
        return redirect()->route('company.login')->with('success', 'Vui Lòng Kiểm Tra Mail Để Thực Hiện Thay Đổi Mật Khẩu');
    }
    public function getPassCompany()
    {
        return view('company.email.get-pass');
    }
    public function postPassCompany(Company $candidate, Request $request)
    {
        if ($candidate->token === $request->token) {
            if ($request->password === $request->password2) {
                $candidate->update([
                    'token' => null,
                    'password' => bcrypt($request->password)

                ]);
                return redirect()->route('company.login')->with('success', 'Đổi mật khẩu thành công');
            } else {
                return back()->with('error', 'Mật khẩu không trùng khớp');
            }
        } else {
            return view('email.404');
        }
    }
}
