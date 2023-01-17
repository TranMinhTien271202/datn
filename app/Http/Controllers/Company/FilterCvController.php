<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Education;
use App\Models\Major;
use App\Models\Experience;
use App\Models\JobPostActivities;
use App\Models\OpenCv;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\SkillSeeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterCvController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
        $this->v['activeRoute'] = 'filter';
    }
    public function index(Request $request)
    {
        $this->v['title'] = 'Tìm kiếm ứng viên phù hợp';
        $company_id = auth('company')->user()->id;
        $this->v['company'] = Company::find($company_id);

        $data = DB::table('job_post_activities')->where('company_id', $company_id)->select('seeker_id')->groupby('seeker_id')->pluck('seeker_id')->toArray();
        $query = SeekerProfile::whereNotIn('id',$data)->where('is_active', 1)->with('candidate');
        if($request->ajax()) {
            $gender = $request->get('id_gender');
            $skill = $request->get('id_skill');
            $major = $request->get('id_major');
            $type_degree = $request->get('type_degree');
            $name_edu = $request->get('name_edu');
            $name_cty = $request->get('name_cty');
            $search_address = $request->get('search_address');
            $selectYearKn = $request->get('selectYearKn');
            switch($selectYearKn) {
                case 0:
                    $dk = "=";
                    $value = '0';
                    break;
                case 1:
                    $dk = "<";
                    $value = '1';
                    break;
                case 2:
                    $dk = "<=";
                    $value = '1';
                    break;
                case 3:
                    $dk = "<=";
                    $value = '2';
                    break;
                case 4:
                    $dk = "<=";
                    $value = '3';
                    break;
                case 5:
                    $dk = "<=";
                    $value = '4';
                    break;
                case 6:
                    $dk = "<=";
                    $value = '5';
                    break;
                case 7:
                    $dk = ">";
                    $value = '5';
                    break;

                    default:
                    $dk = "!=";
                    $value = '0';
            }
            if(!empty($skill)) {
                $query = $query->whereHas('seekerSkill', function($q) use ($skill) {
                    $q->where('skill_id', $skill);
                });
            }
            if(!empty($gender)){
                $query = $query->whereHas('candidate', function($q) use ($gender) {
                    $q->where('gender', $gender);
                });
            }
            if(!empty($major)) {
                $query = $query->where('major_id', $major);
            }
            if(!empty($type_degree)) {
                $query = $query->whereHas('education', function($q) use ($type_degree) {
                    $q->where('type_degree', 'like', "%{$type_degree}%");
                });
            }
            if(!empty($name_edu)) {
                $query = $query->whereHas('education', function($q) use ($name_edu) {
                    $q->where('name_education', 'like', "%{$name_edu}%");
                });
            }
            if(!empty($name_cty)) {
                $query = $query->whereHas('experience', function($q) use ($name_cty) {
                    $q->where('company_name', 'like', "%{$name_cty}%");
                });
            }
            if(!empty($search_address)) {
                $query = $query->where('address', 'like', "%{$search_address}%");
            }
            if(isset($selectYearKn)) {
                $query = $query->where('total_exp',$dk, $value);
            }

        }
        $this->v['seekerProfile'] = $query->paginate(9);
        $this->v['major'] = Major::all();
        $this->v['skill'] = Skill::all();
        $this->v['nameEdu'] = Education::distinct()->select('name_education')->get();
        $this->v['getNameCty'] = Experience::distinct()->select('company_name')->get();
        if(!empty($this->v['seekerProfile'])){
            foreach($this->v['seekerProfile'] as $item) {
                $this->v['list_skill'][$item->id] = SkillSeeker::where('seeker_id', $item->id)->paginate(2);
                $this->v['getMajor'][$item->major_id] = Major::where('id', $item->major_id)->first();

                $this->v['getExperience'][$item->id] = Experience::where('seeker_id', $item->id)->get();
            }
        }
        
        if ($request->ajax()) {
            return view('company.filter-cv.list-view',$this->v);
        }
        return view('company.filter-cv.index', $this->v);

    }

}
