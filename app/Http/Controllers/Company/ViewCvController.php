<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\SkillSeeker;
use Illuminate\Support\Facades\Session;

class ViewCvController extends Controller
{
    private $v;
    public function __construct()
    {
        $this->v = [];
    }

    public function viewProfile($id)
    {
        $seekerProfile = SeekerProfile::where('id', $id)->first();

        $this->v['skills'] = Skill::all();
        $this->v['major'] = Major::all();
        $this->v['maJor'] = Major::all();

        if (!empty($seekerProfile)) {
            $this->v['candidate'] = Candidate::where('id', $seekerProfile->candidate_id)->first();
            $this->v['seekerProfile'] = $seekerProfile;

            $this->v['experiences'] = Experience::where('seeker_id', $seekerProfile->id)->get();
            $this->v['educations'] = Education::where('seeker_id', $seekerProfile->id)->get();
            $this->v['list_skill'] = SkillSeeker::where('seeker_id', $seekerProfile->id)->get();
            $this->v['certificates'] = Certificate::where('seeker_id', $seekerProfile->id)->get();

            $this->v['title_CV'] = "CV-".$this->v['seekerProfile']->name;

            return view('company.view-cv.index', $this->v);

        }else {
            Session::flash('error', 'Không tìm thấy CV!');
            return redirect()->route('company.filter');
        }
    }

    public function viewProfileHidden($id)
    {
        $seekerProfile = SeekerProfile::where('candidate_id', $id)->first();
        $this->v['skills'] = Skill::all();
        $this->v['major'] = Major::all();
        $this->v['maJor'] = Major::all();

        if (!empty($seekerProfile)) {
            $this->v['candidate'] = Candidate::where('id', $seekerProfile->id)->first();
            $this->v['seekerProfile'] = $seekerProfile;

            $this->v['experiences'] = Experience::where('seeker_id', $seekerProfile->id)->get();
            $this->v['educations'] = Education::where('seeker_id', $seekerProfile->id)->get();
            $this->v['list_skill'] = SkillSeeker::where('seeker_id', $seekerProfile->id)->get();
            $this->v['certificates'] = Certificate::where('seeker_id', $seekerProfile->id)->get();

            $this->v['title_CV'] = "CV-".$this->v['seekerProfile']->name;

            return view('company.view-cv.cvHiddenInfo', $this->v);

        }else {
            Session::flash('error', 'Không tìm thấy CV!');
            return redirect()->route('company.filter');
        }
    }
}
