<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\JobPostRequest;
use App\Models\JobPost;
use App\Models\JobPostActivities;
use App\Models\Major;
use App\Models\Skill;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JobPostController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
        $this->v['activeRoute'] = 'post';
    }

    public function index(Request $request)
    {
        $company_id = auth('company')->user()->id;
        $this->v['title'] = 'Quản lý tin tuyển dụng';
        $this->v['posts'] = JobPost::with('activities')->where('company_id',$company_id)
                    ->when($request->has("search"),function($q)use($request){
                        return $q->where("title","like","%".$request->get("search")."%");
                    })->orderBy('created_at', 'DESC')->paginate(config('paginate.post.index'));
        if ($request->ajax()) {
            return view('company.post.tablePost',$this->v);
        }
        return view('company.post.index',$this->v);
    }

    public function create()
    { 
        $this->v['title'] = 'Đăng tin tuyển dụng';
        $this->v['majors'] = Major::all();
        $this->v['skills'] = Skill::all();
        return view('company.post.add',$this->v);
    }

    public function store(JobPostRequest $request)
    {
        try {
            $data = $request->all();
            $data['company_id'] = auth('company')->user()->id;
            $skill = $request->input('skill');
            unset($data['files']);
            $data['start_date'] = Carbon::now();
            $res = JobPost::create($data);
            $res->skills()->attach($skill);
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('company.post.index');
        } catch (Exception $e) {
            Session::flash('error', 'Lỗi thêm mới!');
            throw new Exception($e->getMessage());
            return Redirect()->route('company.post.create');
        }

    }

    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $this->v['title'] = 'Sửa tin tuyển dụng';
        $this->v['majors'] = Major::all();
        $this->v['skills'] = Skill::all();
        $this->v['jobPost'] = JobPost::with('skills')->find($id);
        $this->v['skillActive'] = $this->v['jobPost']->skills->pluck('id')->toArray();
        return view('company.post.edit',$this->v);
    }

    public function update(JobPostRequest $request, $id)
    {
        try {
            $model = JobPost::find($id);
            $data = $request->all();
            $data['company_id'] = auth('company')->user()->id;
            $skill = $request->input('skill');
            unset($data['files']);
            $model->skills()->sync($skill);
            $res = $model->update($data);
            Session::flash('success', 'Sửa thành công!');
            return Redirect()->route('company.post.index');
        } catch (Exception $e) {
            Session::flash('error', 'Lỗi thêm mới!');
            throw new Exception($e->getMessage());
            return Redirect()->route('company.post.edit',$id);
        }
    }

    public function profileApply(Request $request,$id){
        $this->v['title'] = 'CV ứng tuyển';
        $model = JobPost::with('seekerProfiles')->find($id);
        $this->v['postId'] = $id;
        $this->v['pageApplied'] = '';
        $this->v['listSeeker'] = $model->seekerProfiles()
                ->where('is_function',0)
                ->when($request->has("search"),function($q)use($request){
                    return $q->where("name","like","%".$request->get("search")."%");
                })->orderBy('created_at', 'DESC')->paginate(config('paginate.post.profileApply'));
        if ($request->ajax()) {
            $array_url = explode('/',session()->all()['_previous']['url']);
            if(session()->all()['_previous']['url'] == url()->current()){
                return view('company.post.tableApplied',$this->v);
            }else{
                if (empty($request->get('showTable'))) {
                    $this->v['pageApplied'] = 'table';
                    return view('company.post.rowApplied',$this->v);
                }else{
                    if ($request->has("showTable")) {
                        $this->v['pageApplied'] = 'table';
                    }
                    return view('company.post.tableApplied',$this->v);
                }
                
            }
        }
        return view('company.post.applied',$this->v);
    }

    public function destroy($id)
    {
        //
    }
}
