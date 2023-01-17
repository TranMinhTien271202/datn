<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateCvRequest;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Major;
use App\Models\Projects;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\Skill_other;
use App\Models\SkillSeeker;
use App\Models\Tools_used;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class CreateCvController extends Controller
{
    private $v;
    private $message_val;
    public function __construct()
    {
        $this->v = [];
        $this->message_val = [
            'name.required' => 'Vui lòng nhập tên!',
            'company_name.required' => 'Vui lòng nhập tên công ty!',
            'major_id.required' => 'Vui lòng chọn chuyên ngành!',
            'image.required' => 'Vui lòng up ảnh!',
            'image.image' => 'Chọn file ảnh!',
            'image.mimes' => 'Chọn file ảnh có định dạng jpg,png,jpeg!',
            'image.max' => 'Chọn ảnh có kích thước nhỏ hơn 5mb!',
            'name_education.required' => 'Vui lòng nhập tên trường!',
            'majors.required' => 'Vui lòng nhập ngành học!',
            'position.required' => 'Vui lòng nhập vị trí!',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu!',
            'end_date.required' => 'Vui lòng nhập ngày kết thúc!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'email.required' => 'Vui lòng nhập email!',
            'description.required' => 'Vui lòng nhập mô tả!',
            'skill_id.required' => 'Vui lòng chọn kỹ năng!',
            'address.required' => 'Vui lòng nhập địa chỉ!',
            'gpa.max' => 'Điểm không quá 10!',
            'time.required' => 'Vui lòng nhập thời gian!',
            'summary.required' => 'Vui lòng nhập mô tả ngắn!',
            'title.required' => 'Vui lòng nhập tên!'
        ];
    }

    public function createNew() {
        if (session('link')) {
            $myPath     = session('link');
            $loginPath  = url('/login');
            $previous   = url()->previous();
            session(['link' => $previous]);
        }
        else{
             session(['link' => url()->previous()]);
        }
        if(auth('candidate')->check()) {
            $candidate_id = auth('candidate')->user()->id;
            $seeker = new SeekerProfile();
            $seeker->candidate_id = $candidate_id;

            $check_count = SeekerProfile::where('candidate_id', $candidate_id)->count();
            if($check_count >= 3) {
                Session::flash('error', 'Bạn đã đạt giới hạn 3 CV !');
                return redirect()->route('seeker');
            }else {
                $seeker->name = auth('candidate')->user()->name;
                $seeker->email = auth('candidate')->user()->email;
                $seeker->phone = auth('candidate')->user()->phone;
                $seeker->is_active = 0;
                $seeker->save();
                $id_new = $seeker->id;
                return redirect()->route('CreateCV', ['idsee' => $id_new]);
            }
        }
        return redirect()->route('candidate.login');
    }

    public function index(Request $request)
    {
        if(auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $idsee = $request->route('idsee');
            $seeker = SeekerProfile::where('id', $idsee)->first();
            $this->v['seeker'] = $seeker;
            $this->v['skills'] = Skill::all();
            $this->v['maJor'] = Major::all();

            if (!empty($seeker)) {
                $this->v['experiences'] = Experience::where('seeker_id', $seeker->id)->get();
                $this->v['educations'] = Education::where('seeker_id', $seeker->id)->get();
                $this->v['list_skill'] = SkillSeeker::where('seeker_id', $seeker->id)->get();
                $this->v['certificates'] = Certificate::where('seeker_id', $seeker->id)->get();
                $this->v['skill_other'] = Skill_other::where('seeker_id', $seeker->id)->get();
                $this->v['projects'] = Projects::where('seeker_id', $seeker->id)->get();
                $this->v['tool_used'] = Tools_used::where('seeker_id', $seeker->id)->get();

                //active skills
                $this->v['skillActive'] = $this->v['list_skill']->pluck('skill_id')->toArray();
            }
            return view('client.upcv.cv', $this->v);
            
        }
        return redirect()->route('candidate.login');
    }

    public function saveInfo(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric|max:10',
            'email' => 'required',
            'description' => 'required',
            'candidate_id' => 'required',
            'major_id' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5000',
            'address' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();
            $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['cols']['image'] = $this->uploadFile($request->file('image'));
            } 

            unset($params['cols']['_token']);
            $model = new SeekerProfile();
            $res = $model->saveAdd($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Tạo mới thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Tạo mới thành công!',
                    'data' => $params['cols'],
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function updateInfo(Request $request)
    {

        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'description' => 'required',
            'candidate_id' => 'required',
            'major_id' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:5000',
            'address' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['cols']['image'] = $this->uploadFile($request->file('image'));
            }
            unset($params['cols']['_token']);
            $model = new SeekerProfile();
            $res = $model->saveUpdate($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Cập nhật thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Cập nhật thành công!',
                    'data' => $params['cols'],
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi Cập nhật!'
                ]);
            }
        }
    }

    public function saveExperience(Request $request)
    {
        $seeker_id = $request->get('seeker_id');
        $check_max = Experience::where('seeker_id', $seeker_id)->count();
        if($check_max >= 5) {
            return response()->json([
                'is_max' => true,
                'error' => 'Tối đa 5 mục kinh nghiệm!'
            ]);
        }else {
            $rules = [
                'company_name' => 'required',
                'position' => 'required',
                'start_date' => 'required',
                'description' => 'required',
            ];
            $messages =  $this->message_val;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()]);
            }else {
                $params = [];
                $params['cols'] = $request->post();
                $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
                $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();
    
                $bat_dau = strtotime($params['cols']['start_date']);
                if(empty($ket_thuc)){
                    $ket_thuc = Carbon::now()->toDateTimeString();
                }else {
                    $ket_thuc = $params['cols']['end_date'];
                }
                $ket_thuc = strtotime($ket_thuc);
                $tong = $ket_thuc - $bat_dau;
                $day = floor($tong / 60 / 60 / 24);
                $day = round($day /30/12, 1);
    
                $params['cols']['time_exp'] =  $day;
                
                $seeker = SeekerProfile::where('id', $params['cols']['seeker_id'])->first();
                $seeker->total_exp = $seeker->total_exp += $day;
                $seeker->save();
    
                unset($params['cols']['_token']);
                $model = new Experience();
    
                $res = $model->saveAdd($params);
                if ($res == null) {
                    return response()->json([
                        'is_check' => false,
                        'error' => 'Tạo mới thất bại!'
                    ]);
                }
                if ($res == 1) {
                    return response()->json([
                        'is_check' => true,
                        'success' => 'Tạo mới thành công!',
                    ]);
                } else {
                    return response()->json([
                        'is_check' => false,
                        'error' => 'Lỗi tạo mới!'
                    ]);
                }
            }
        }
    }

    public function updateExperience(Request $request, $id)
    {

        $rules = [
            'company_name' => 'required',
            'position' => 'required',
            'start_date' => 'required',
            'description' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();

            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            $bat_dau = strtotime($params['cols']['start_date']);
            if(empty($ket_thuc)){
                $ket_thuc = Carbon::now()->toDateTimeString();
            }else {
                $ket_thuc = $params['cols']['end_date'];
            }
            $ket_thuc = strtotime($ket_thuc);
            $tong = $ket_thuc - $bat_dau;
            $day = floor($tong / 60 / 60 / 24);
            $day = round($day /30/12, 1);

            $params['cols']['time_exp'] =  $day;

            $seeker = SeekerProfile::where('id', $params['cols']['seeker_id'])->first();
            $seeker->total_exp = $seeker->total_exp += $day;
            $seeker->save();

            unset($params['cols']['_token']);
            $model = new Experience();
            $params['cols']['id'] = $id;
            $res = $model->saveUpdate($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Cập nhật thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Cập nhật thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function deleteExperience(Request $request)
    {
        $id = $request->id;
        if (isset($id)) {
            $exp = Experience::find($id);
            if(!isset($exp)){
                return redirect()->route('CreateCV');
            }
            $bat_dau = strtotime($exp->start_date);
            if(empty($ket_thuc)){
                $ket_thuc = Carbon::now()->toDateTimeString();
            }else {
                $ket_thuc = $exp->end_date;
            }
            $ket_thuc = strtotime($ket_thuc);
            $tong = $ket_thuc - $bat_dau;
            $day = floor($tong / 60 / 60 / 24);
            $day = round($day /30/12, 1);

            $seeker = SeekerProfile::where('id', $exp->seeker_id)->first();
            $seeker->total_exp = $seeker->total_exp -= $day;
            $seeker->save();

            $exp->delete();

            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    public function saveSkills(Request $request)
    {
        $data = $request->all();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        unset($data['_token']);

        SkillSeeker::where('seeker_id', $data['seeker_id'])->delete();

        foreach ($data['skill_id'] as $skill) {
            SkillSeeker::create([
                'seeker_id' => $data['seeker_id'],
                'skill_id' => $skill,
            ]);
        }
        return response()->json(['success' => 'Cập nhật thành công!']);
    }

    public function DeleteAllSkill($idsee)
    {
        SkillSeeker::where('seeker_id', $idsee)->delete();
        Session::flash('success', 'Xóa thành công!');
        return redirect()->route('CreateCV', ['idsee' => $idsee]);
    }

    public function saveEducation(CreateCvRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();

        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Education();

        $res = $model->saveAdd($params);
        if ($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return back();
        } else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return back();
        } else {
            Session::flash('error', 'Lỗi thêm mới!');
            return back();
        }
    }

    public function updateEducation(CreateCvRequest $request, $id)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Education();
        $params['cols']['id'] = $id;
        $res = $model->saveUpdate($params);
        if ($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return back();
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật thành công!');
            return back();
        } else {
            Session::flash('error', 'Lỗi cập nhật!');
            return back();
        }
    }

    public function deleteEducation($id)
    {
        if (isset($id)) {
            Education::find($id)->delete();

            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    //certificates
    public function saveCertificate(CreateCvRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();

        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Certificate();

        $res = $model->saveAdd($params);
        if ($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return back();
        } else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return back();
        } else {
            Session::flash('error', 'Lỗi thêm mới!');
            return back();
        }
    }

    public function updateCertificate(CreateCvRequest $request, $id)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Certificate();
        $params['cols']['id'] = $id;
        $res = $model->saveUpdate($params);
        if ($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return back();
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật thành công!');
            return back();
        } else {
            Session::flash('error', 'Lỗi cập nhật!');
            return back();
        }
    }

    public function deleteCertificate($id)
    {
        if (isset($id)) {
            Certificate::find($id)->delete();
            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    // project
    public function saveProject(Request $request) {
        $rules = [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'summary' => 'required',
            'description' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();

            $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Projects();

            $res = $model->saveAdd($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Tạo mới thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Tạo mới thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function updateProject(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'summary' => 'required',
            'description' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Projects();
            $params['cols']['id'] = $id;
            $res = $model->saveUpdate($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Cập nhật thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Cập nhật thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function deleteProject($id)
    {
        if (isset($id)) {
            Projects::find($id)->delete();
            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    //skill_other
    public function saveSkillOther(Request $request) {
        $rules = [
            'title' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();

            $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Skill_other();

            $res = $model->saveAdd($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Tạo mới thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Tạo mới thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function updateSkillOther(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Skill_other();
            $params['cols']['id'] = $id;
            $res = $model->saveUpdate($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Tạo mới thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Tạo mới thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function deleteSkillOther($id)
    {
        if (isset($id)) {
            Skill_other::find($id)->delete();
            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    // project
    public function saveTools(Request $request) {
        $rules = [
            'title' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();

            $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Tools_used();

            $res = $model->saveAdd($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Tạo mới thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Tạo mới thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function updateTools(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
        ];
        $messages =  $this->message_val;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }else {
            $params = [];
            $params['cols'] = $request->post();
            $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

            unset($params['cols']['_token']);
            $model = new Tools_used();
            $params['cols']['id'] = $id;
            $res = $model->saveUpdate($params);
            if ($res == null) {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Cập nhật thất bại!'
                ]);
            }
            if ($res == 1) {
                return response()->json([
                    'is_check' => true,
                    'success' => 'Cập nhật thành công!',
                ]);
            } else {
                return response()->json([
                    'is_check' => false,
                    'error' => 'Lỗi tạo mới!'
                ]);
            }
        }
    }

    public function deleteTools($id)
    {
        if (isset($id)) {
            Tools_used::find($id)->delete();
            return response()->json([
                'is_check' => true,
                'success' => 'Xóa thành công!',
            ]);
        }
        return response()->json([
            'is_check' => false,
            'error' => 'Xóa thất bại!'
        ]);
    }

    // up ảnh
    public function uploadFile($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('images', $fileName, 'public');
    }

    public function getPdf(Request $request)
    {
        $id = auth('candidate')->user()->id;
        $idsee = $request->route('idsee');
        $seeker = SeekerProfile::where('id', $idsee)->first();
        $this->v['seeker'] = $seeker;
        $this->v['skills'] = Skill::all();
        $this->v['major'] = Major::all();
        $this->v['maJor'] = $this->v['major'] ;
        
        if(isset($seeker->image)){
            $imagePath = public_path("storage/$seeker->image");
            $this->v['imageCV'] = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));
        }

        if (!empty($seeker)) {
            $this->v['experiences'] = Experience::where('seeker_id', $seeker->id)->get();
            $this->v['educations'] = Education::where('seeker_id', $seeker->id)->get();
            $this->v['list_skill'] = SkillSeeker::where('seeker_id', $seeker->id)->get();
            $this->v['certificates'] = Certificate::where('seeker_id', $seeker->id)->get();
            $this->v['skill_other'] = Skill_other::where('seeker_id', $seeker->id)->get();
            $this->v['projects'] = Projects::where('seeker_id', $seeker->id)->get();
            $this->v['tool_used'] = Tools_used::where('seeker_id', $seeker->id)->get();

            $this->v['info_candidate'] = Candidate::where('id', $id)->first();

            //active skills
            $this->v['skillActive'] = $this->v['list_skill']->pluck('skill_id')->toArray();
        }

        //lưu rồi mở file
        $pdf = Pdf::loadView('client.upcv.index', $this->v)
            ->setOptions([
            'enable_remote' => true,
            'chroot'  => public_path('storage/'),
        ]);
        $fileName = 'CV-' . $seeker->name .'_'. time() . rand('0', '99') . '.pdf';

        $seekerA = SeekerProfile::where('id', $idsee)->first();
        $file_path = public_path('upload/cv/'.$seekerA->path_cv);

        if (is_file($file_path)) {
            unlink($file_path);
        }

        SeekerProfile::where('id', $idsee)->update([
            'path_cv' => $fileName
        ]);

        $fileName = public_path('upload/cv/'. $fileName);
        $pdf->save($fileName);

        Session::flash('success', 'Cập nhật CV thành công!');
        return redirect(session('link')); 
        return redirect()->route('seeker');
    }
}
