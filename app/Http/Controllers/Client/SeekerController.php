<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Upcv;
use App\Models\Major;
use App\Models\SeekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\JobPostActivities;

class SeekerController extends Controller
{
    public function index(Request $request)
    {
        if(auth('candidate')->check()) {
            $id_candidate = auth('candidate')->user()->id;
            $data = SeekerProfile::where('candidate_id', $id_candidate)->paginate(10);
            $maJor = Major::all();
            if($request->ajax()) {
                $id = $request->id;
                $get_all_seeker = SeekerProfile::where('candidate_id', $id_candidate)->where('is_active', 1)->first();
                if(isset($get_all_seeker->is_active)) {
                    $get_all_seeker->is_active = 0;
                    $get_all_seeker->save();
                }

                $seeker_up = SeekerProfile::find($id);
                $seeker_up->is_active = 1;
                $seeker_up->save();
                return response()->json([
                    'success' => 'Cập nhật thành công!',
                ]);
            }
            return view('client.upcv.upcv', compact('data', 'maJor'));
        }
        return redirect()->route('candidate.login');
    }
    public function store(Upcv $request)
    {
        $rules = [
            'path_cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ];
        $message = [
            'path_cv.required' => 'Không được bỏ trống',
            'path_cv.mimes' => 'Vui lòng tải lên file pdf hoặc docs',
            'path_cv.max' => 'Vui lòng tải lên file không quá 2mb',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect('seeker')->withErrors($validator);
        }
        $candidate_id = auth('candidate')->user()->id;
        $seeker = new SeekerProfile();
        $check_count = SeekerProfile::where('candidate_id', $candidate_id)->count();
        if($check_count >= 3) {
            Session::flash('error', 'Bạn đã đạt giới hạn 3 CV !');
            return redirect()->route('seeker');
        }else {
            $get_all_seeker = SeekerProfile::where('candidate_id', $candidate_id)->where('is_active', 1)->first();
                if(isset($get_all_seeker->is_active)) {
                    $get_all_seeker->is_active = 0;
                    $get_all_seeker->save();
                }
            $seeker->candidate_id = $candidate_id;
            $seeker->name = auth('candidate')->user()->name;
            $seeker->email = auth('candidate')->user()->email;
            $seeker->phone = auth('candidate')->user()->phone;
            $seeker->is_active = 1;
            $get_pdf = $request->file('path_cv');
            $path_pdf = 'upload/cv';
            if ($get_pdf) {
                $get_name_pdf = $get_pdf->getClientOriginalName();
                $name_pdf = current(explode('.', $get_name_pdf));
                $new_pdf = $name_pdf . rand(0, 99) . '.' . $get_pdf->getClientOriginalExtension();
                $get_pdf->move($path_pdf, $new_pdf);
                $seeker->path_cv = $new_pdf;
            }
            $seeker->save();
        }
        return redirect('seeker')->with('success', 'Thêm Thành Công');
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        if(isset($id)) {
            $seeker = SeekerProfile::find($id);
            if($seeker->is_active == 1){
                return response()->json([
                    'is_check' => false,
                    'error' => 'Vui lòng chuyển trạng thái hoặc tạo cv mới!',
                ]);
            }
            if(isset($seeker->path_cv)){
                $file_path = public_path('upload/cv/' . $seeker->path_cv);
                if (is_file($file_path)) {
                    unlink($file_path);
                }
            }
            if(isset($seeker)){
                $job_at = JobPostActivities::where('seeker_id' , $id)->get();
                if(isset($job_at) && $job_at->count() > 0){
                    foreach ($job_at as $j) {
                        $j->delete();
                    }
                }
                $seeker->delete();
                return response()->json([
                    'is_check' => true,
                    'success' => 'Xóa thành công!',
                ]);
            }
            return response()->json([
                'is_check' => false,
                'error' => 'Xóa thất bại!'
            ]);
        }else {
            return response()->json([
                'is_check' => false,
                'error' => 'Không tìm thấy cv!'
            ]);
        }
    }
}
