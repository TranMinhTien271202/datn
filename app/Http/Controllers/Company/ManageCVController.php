<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\JobPostActivities;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\SkillSeeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageCVController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
        $this->v['activeRoute'] = 'manage-cv';
    }

    public function index(Request $request) {
        $this->v['title'] = 'Quản lý CV';
        $this->v['major'] = Major::all();
        $this->v['skill'] = Skill::all();
        $company_id = auth('company')->user()->id;
        if($request->ajax() && !empty($request->get('is_see')) && !empty($request->get('is_function')) ){

            $is_function = $request->get('is_function') == 5 ? 0 : $request->get('is_function');
            $is_see = $request->get('is_see') == 3 ? 0 : $request->get('is_see');

            $dk_fun = $request->get('is_function') == -1 ? "!=" : "=";
            $dk_see = $request->get('is_see') == -1 ? "!=" : "=";
            

            $this->v['listCV'] = JobPostActivities::with('seeker_profile')
                            ->where('company_id',$company_id)
                            ->where('is_see', $dk_see,$is_see)
                            ->where('is_function',$dk_fun,$is_function)
                            // ->orderBy('id', 'DESC')
                            ->groupby('seeker_id')
                            ->select(['seeker_id'])
                            ->paginate(10);
        }
        else{
            $this->v['listCV'] = JobPostActivities::with('seeker_profile')
                                ->where('company_id',$company_id)
                                // ->orderBy('id', 'DESC')
                                ->groupby('seeker_id')
                                ->select(['seeker_id'])
                                ->paginate(10);
        }
        if (!empty($this->v['listCV'] )) {
            $this->v['getDataCV'] = JobPostActivities::where('company_id', $company_id)->get();
            foreach ($this->v['getDataCV']  as $data) {
                $this->v['get_data'][$data->seeker_id] = ['is_see' => $data->is_see, 'is_function' => $data->is_function, 
                                                          'time' =>  $data->time];
            }
            foreach ($this->v['listCV']  as $item) {
                $seeker_id = $item->seeker_id;    
                $this->v['list_skill'][$seeker_id] = SkillSeeker::where('seeker_id', $seeker_id)->paginate(4);

                $this->v['infoCandidate'][$item->seeker_profile->candidate_id] = Candidate::where('id', $item->seeker_profile->candidate_id)->first();
            }
        }
        if ($request->ajax()) {
            return view('company.manage-cv.selectView',$this->v);
        }
        return view('company.manage-cv.index',$this->v);
    }
}
