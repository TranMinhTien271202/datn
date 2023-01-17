<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CandidateRequest;
use App\Models\Candidate;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index()
    {
        $data = Candidate::where('status', 1)->get();
        $maJor = Major::all();
        return view('client.candidate.candi-list', compact('data', 'maJor'));
    }
    public function detail()
    {
        $id = auth('candidate')->user()->id;
        $detail = Candidate::where('id', $id)->first();
        $maJor = Major::all();
        return view('client.candidate.candidate-profile', compact('detail', 'maJor'));
    }
    public function update(CandidateRequest $request, $id)
    {
        $id = auth('candidate')->user()->id;
        $method_route = 'detail';
        $params = [];
        $params['cols'] = $request->post();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $params['cols']['avatar'] = $this->uploadFile($request->file('avatar'));
        }

        unset($params['cols']['_token']);
        $model = new Candidate();
        $params['cols']['id'] = $id;
        $res = $model->saveUpdateProfile($params);
        if ($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật  thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        } else {
            Session::flash('error', 'Lỗi cập nhật!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
    }
    public function change()
    {
        $maJor = Major::all();
        $id = auth('candidate')->user()->id;
        $detail = Candidate::where('id', $id)->first();
        return view('client.candidate.change-password', compact('maJor', 'detail'));
    }
    public function update_pass(Request $request)
    {
        $rules = [
            'password' => 'required',
            'password_old' => 'required',
            're_password' => 'required|same:password',
        ];
        $messages = [
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password_old.required' => 'Vui lòng nhập mật khẩu cũ',
            're_password.required' => 'Vui lòng nhập lại mật khẩu mới',
            're_password.same' => 'Mật khẩu nhập lại không khớp',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('change_password')->withErrors($validator);
        }
        $id = auth('candidate')->user()->id;
        $params = [];
        $params['cols'] = $request->post();
        unset($params['cols']['_token']);

        if (Hash::check($params['cols']['password_old'], auth('candidate')->user()->password)) {
            $model = new Candidate();
            unset($params['cols']['password_old']);
            unset($params['cols']['re_password']);
            $params['cols']['id'] = $id;
            $res = $model->saveUpdate($params);
            if ($res == null) {
                Session::flash('success', 'Cập nhật thành công!');
                return Redirect()->back();
            }
            if ($res == 1) {
                Session::flash('success', 'Cập nhật  thành công!');
                return Redirect()->back();
            } else {
                Session::flash('error', 'Lỗi cập nhật!');
                return Redirect()->back();
            }
        }else {
            Session::flash('error', 'Mật khẩu cũ không đúng!');
            return Redirect()->back();
        }
    }
    public function uploadFile($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('images', $fileName, 'public');
    }
    public function status(Candidate $candidate, $type){
        if ($candidate->type == 1) {
            $candidate->update(['type' => 0]);
            return redirect()->back();
        } else {
            $candidate->update(['type' => 1]);
            return redirect()->back();
        }
    }
}
