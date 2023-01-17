<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\company;
use App\Models\JobPost;
use App\Models\JobPostActivities;
use App\Models\JobSkill;
use App\Models\JobSpeed;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\Shortlist;
use App\Models\Shortlisted;
use App\Models\Skill;
use App\Models\SkillPost;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
    }
    public function index()
    {
        $data = JobPost::where('status', 1)->get();
        $maJor = Major::all();
        return view('client.home', compact('data', 'maJor'));
    }
    
    public function modal_selectCV() {
        $id_candidate = auth('candidate')->user()->id;
        $data = SeekerProfile::where('candidate_id', $id_candidate)->paginate(10);
        return view('client.job.modal',compact('data'));
    }

    public function job(Request $request)
    {
        $job_short = [];
        $jobspeed = [];
        $Skill = Skill::all();
        $data = Skill::join('skill_posts', 'skills.id', '=', 'skill_posts.skill_id')
            ->join('job_posts', 'skill_posts.post_id', '=', 'job_posts.id')
            ->where(function ($q) use ($request) {
                $search = $request['searchText'];
                $major = $request['searchMajor'];
                $type = $request['searchType'];
                $skill = $request['searchSkill'];
                if (!empty($search)) {
                    $q->orwhere('job_posts.title', 'LIKE', '%' . $search . '%');
                }
                if (!empty($major)) {
                    $q->where('job_posts.major_id', '=', $major);
                }
                if (!empty($type)) {
                    $q->where('job_posts.type_work', '=', $type);
                }
                if (!empty($skill)) {
                    $q->where('skills.id', '=', $skill);
                }
            })
            ->select('job_posts.*')
            ->distinct()
            ->with(['company', 'major'])
            ->get();
        // dd($data);
        $today = strtotime(Carbon::now());
        $maJor = Major::all();
        $date = date('Y/m/d', time());
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $jobspeed = JobPostActivities::where('seeker_id', $id)->whereDate('created_at', $date)->first();
            $dataUser = Candidate::where('id', $id)->first();
            $data_short = Shortlist::where('candidate_id', $id)->get();
            if (!empty($data_short)) {
                foreach ($data_short as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = $item;
                }
            }
            if ($request->ajax()) {
                return response()->json($data);
            } else {
                return view('client.job.job', compact('data', 'maJor', 'job_short', 'today', 'jobspeed', 'Skill'));
            }
        } else {
            if ($request->ajax()) {
                return response()->json($data);
            } else {
                return view('client.job.job', compact('data', 'maJor', 'job_short', 'today', 'jobspeed', 'Skill'));
            }
        }
    }
    public function job_cat($id)
    {
        $job_short = [];
        $job_cat = Major::where('id', $id)->first();
        $data = JobPost::where('major_id', $id)->where('status', 1)->paginate(10);
        $maJor = Major::all();
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $dataUser = Candidate::where('id', $id)->first();
            $data_short = Shortlist::where('candidate_id', $id)->get();
            if (!empty($data_short)) {
                foreach ($data_short as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = $item;
                }
            }
        }
        return view('client.job.job-cat', compact('data', 'job_cat', 'maJor', 'job_short'));
    }
    public function detail($id)
    {
        $data_job = JobPost::where('id', $id)->first();
        $maJor = Major::all();
        $idJobApplied = [];
        $idJobShort = [];
        $data_job_relate = [];
        $seeker = [];
        if (auth('candidate')->check()) {
            $id_user = auth('candidate')->user()->id;
            $seeker = SeekerProfile::where('candidate_id', $id_user)->first();
            if (!empty($seeker->id)) {
                $dataActive = JobPostActivities::where('seeker_id', $seeker->id)->where('is_function', 0)->get();
                if (!empty($dataActive)) {
                    foreach ($dataActive as $item) {
                        $idJobApplied[$item->job_post_id] = $item;
                    }
                }
                $dataShort = Shortlist::where('candidate_id', $id_user)->get();
                if (!empty($dataShort)) {
                    foreach ($dataShort as $item) {
                        $idJobShort[$item->job_post_id] = $item;
                    }
                }
            }
        }
        $skills = Skill::all();
        $jobPost = JobPost::with('skills')->find($id);
        $skillActive = $jobPost->skills->pluck('id')->toArray();

        $data_job_relate = JobPost::where('major_id', $data_job->major_id)
            ->where('id', '!=', $data_job->id)->take(3)->get();

        return view('client.job.job-detail', compact(
            'data_job',
            'data_job_relate',
            'maJor',
            'idJobApplied',
            'idJobShort',
            'seeker',
            'skills',
            'skillActive'
        ));
    }
    public function searchs(Request $request)
    {
        $data = Skill::join('skill_posts', 'skills.id', '=', 'skill_posts.skill_id')
            ->join('job_posts', 'skill_posts.post_id', '=', 'job_posts.id')
            ->where(function ($q) use ($request) {
                $search = $request['searchText'];
                $major = $request['searchMajor'];
                $type = $request['searchType'];
                $skill = $request['searchSkill'];
                if (!empty($search)) {
                    $q->orwhere('job_posts.title', 'LIKE', '%' . $search . '%');
                }
                if (!empty($major)) {
                    $q->where('job_posts.major_id', '=', $major);
                }
                if (!empty($type)) {
                    $q->where('job_posts.type_work', '=', $type);
                }
                if (!empty($skill)) {
                    $q->where('skills.id', '=', $skill);
                }
            })
            ->select('job_posts.*')
            ->distinct()
            ->with(['company', 'major'])
            ->get();
        return response()->json($data);
    }
    public function searchByTitle($id, Request $request)
    {
        $job = JobPost::where('major_id', $id)->where('title', 'like', '%' . $request->value . '%')->get();
        return response()->json($job);
    }
    public function jobPost(Request $request){
        $this->v['job_short'] = [];
        $jobspeed = [];
        $this->v['Skill'] = Skill::all();
        $skill = $request['skill'];
        $this->v['urlWith'] = '';
        if (empty($skill)) {
            $this->v['data'] = JobPost::with('skills')->where(function ($q) use ($request) {
                $search = $request['search'];
                $major = $request['major'];
                $type = $request['type'];
                $area = $request['area'];
                if (!empty($search)) {
                    $q->orwhere('job_posts.title', 'LIKE', '%' . $search . '%');
                    $this->v['urlWith'] = '?search='.$search;
                }
                if (!empty($major)) {
                    $q->where('job_posts.major_id', '=', $major);
                    $this->v['urlWith'] .= '?major='.$major;
                }
                if (isset($request['type'])) {
                    $q->where('job_posts.type_work', '=', $type);
                    $this->v['urlWith'] .= '?type='.$type;
                }
                if (!empty($area)) {
                    $q->where('job_posts.area', '=', $area);
                    $this->v['urlWith'] .= '?area='.$area;
                }
            })->where('status',1)->paginate(config('paginate.JobPostClient.index'));
        }else{
            $this->v['data'] = JobPost::with('skills')->where(function ($q) use ($request) {
                $search = $request['search'];
                $major = $request['major'];
                $type = $request['type'];
                if (!empty($search)) {
                    $q->orwhere('job_posts.title', 'LIKE', '%' . $search . '%');
                }
                if (!empty($major)) {
                    $q->where('job_posts.major_id', '=', $major);
                }
                if (isset($request['type'])) {
                    $q->where('job_posts.type_work', '=', $type);
                }
                if (!empty($area)) {
                    $q->where('job_posts.area', '=', $area);
                }
            })->whereHas('skills', function ($q) use ($skill) {
                $q->where('skill_id', $skill);
            })->where('status',1)->paginate(config('paginate.JobPostClient.index'));
            $this->v['urlWith'] .= '?skill='.$skill;
        }
        
        $this->v['today'] = strtotime(Carbon::now());
        $this->v['maJor'] = Major::all();
        $date = date('Y/m/d', time());
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $this->v['jobspeed'] = JobPostActivities::where('seeker_id', $id)->whereDate('created_at', $date)->first();
            $dataUser = Candidate::where('id', $id)->first();
            $data_short = Shortlist::where('candidate_id', $id)->get();
            if (!empty($data_short)) {
                foreach ($data_short as $item) {
                    $id_post = $item->job_post_id;
                    $this->v['job_short'][$id_post] = $item;
                }
            }
            
        } 
        if ($request->ajax()) {
            return view('client.job.table-job', $this->v);
        } else {
            return view('client.job.index', $this->v);
        }
        
    }
}
