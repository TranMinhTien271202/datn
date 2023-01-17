<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\FeedbackRequest;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Feedback;
use App\Models\HistoryPayment;
use App\Models\JobPostActivities;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\SkillSeeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DetailCandidateController extends Controller
{

    public function index(Request $request, $id)
    {
        $company_id = auth('company')->user()->id;
        $data  =  SeekerProfile::with('major', 'skill', 'candidate')->where('candidate_id', $id)->first();

        $check = JobPostActivities::where([
            ['company_id','=',$company_id],
            ['seeker_id','=', $data->id],
            ])->get()->count();

        if($check == 0) {
            return redirect()->route('company.detail-profile.hidden', ['id' => $id]);
        }

        $title = "Thông tin ứng viên";
        $activeRoute = "Profile";
        $maJor  = Major::all();
        $education = Education::where('seeker_id', $data->id)->get()->toArray();
        $seekerSkill = SkillSeeker::where('seeker_id', $data->id)->get();
        $certificate = Certificate::where('seeker_id', $data->id)->get();
        $timeNow = Carbon::now();
        $exp = Experience::where('seeker_id', $data->id)->get()->toArray();
        return view('company.detail-candidate.index', compact('title', 'activeRoute', 'maJor', 'data', 'education', 'exp', 'seekerSkill','timeNow','certificate'));
    }

    public function viewHidden(Request $request, $id) {
        $company_id = auth('company')->user()->id;
        $data  =  SeekerProfile::with('major', 'skill', 'candidate')->where('candidate_id', $id)->first();
        $check = JobPostActivities::where([
                ['company_id','=',$company_id],
                ['seeker_id','=', $data->id],
                ['is_function','=',2]
            ])->get()->count();
        if($check > 0) {
            return redirect()->route('company.detail-candidate.index', ['id' => $id]);
        }
        if ($request->ajax()) {
            
            $idseeker =  $request->get('idseeker');
            $coin = $request->get('coin');
            $company = Company::where('id', $company_id)->first();
            if($company->coin < $coin){
                return response()->json([
                    'success'=> false,
                    'message' => 'Số dư không đủ, vui lòng nạp thêm!'
                ]);
            }else {
                $company->coin = $company->coin - $coin;
                $company->save();

                $history = new HistoryPayment();
                $history->user_id = $company_id;
                $history->note = "Thực hiện mua ứng viên - ".$coin." coin số dư còn lại ".$company->coin." coin";
                $history->coin = $coin;
                $history->type_coin = 0;
                $history->type_account = 0;
                $history->created_at = Carbon::now()->toDateTimeString();
                $history->updated_at = Carbon::now()->toDateTimeString();
                
                $history->save();

                $job_activity = new JobPostActivities();
                $job_activity->seeker_id = $idseeker;
                $job_activity->is_see = 1;
                $job_activity->company_id = $company_id;
                $job_activity->is_function = 2;
                $job_activity->created_at = Carbon::now()->toDateTimeString();
                $job_activity->updated_at = Carbon::now()->toDateTimeString();
                $job_activity->save();
            
                return response()->json([
                    'success'=> true,
                    'message' => 'Mở khóa thành công!',
                    'nameSeeker' => $data->name,
                    'openEmail' => $data->email,
                    'openPhone' => $data->phone,
                ]);
            }
        }

        $title = "Thông tin ứng viên";
        $activeRoute = "Profile";
        $maJor  = Major::all();
        $education = Education::where('seeker_id', $data->id)->get()->toArray();
        $seekerSkill = SkillSeeker::where('seeker_id', $data->id)->get();
        $certificate = Certificate::where('seeker_id', $data->id)->get();
        $timeNow = Carbon::now();
        $exp = Experience::where('seeker_id', $data->id)->get()->toArray();
        return view('company.detail-candidate.viewHidden', compact('title', 'activeRoute', 'maJor', 'data', 'education', 'exp', 'seekerSkill','timeNow','certificate'));
    }
    public function feedback($id) {
        $title ='Đánh giá ứng viên';
        $activeRoute = "Profile";
        $data = Candidate::where('id',$id)->first();
        return view('company.detail-candidate.feedback',compact('data','title','activeRoute'));

    }
    public function saveFeedback(FeedbackRequest $request, $id)
    {
        $id_user = auth('company')->user()->id;
        $feedback = new Feedback();
        $history = new HistoryPayment();
        $company  = Company::where('id', $id_user)->first(); 
        $data = Feedback::where('company_id', $id_user)->where('candidate_id', $id)->get();
        $seeker = SeekerProfile::where('candidate_id', $id)->first();
        $a = count($data);
        if ($a == 0) {
            $feedback->rate = $request->rate;
            $feedback->candidate_id = $id;
            $feedback->company_id = $id_user;
            $feedback->title = $request->title;
            $feedback->satisfied = $request->satisfied;
            $feedback->unsatisfied = $request->unsatisfied;
            $feedback->like_text = $request->like_text;
            $feedback->improve = $request->improve;
            $feedback->is_candidate = "1";
            $feedback->is_reality = $request->reality;
            $company->coin += 2;
            // 
            if($request->rate == 1){
                if($seeker->coin >0){
                    $seeker->coin -= 2;
                }
            }else if($request->rate == 2){
                if($seeker->coin >0){
                    $seeker->coin -= 1;
                }
            }else if($request->rate == 4){
                $seeker->coin += 1;
            }else if($request->rate == 5){
                $seeker->coin += 2;
            }
            //    
            $history->user_id = $id_user;
                $history->note = "Thực hiện feedback ứng viên +2 coin còn lại ".$company->coin." coin";
                $history->coin = $company->coin;
                $history->type_coin = 0;
                $history->type_account = 0;
                $history->created_at = Carbon::now()->toDateTimeString();
                $history->updated_at = Carbon::now()->toDateTimeString();
            ////
            $feedback->save();
            $company->save();
            $history->save();
            $seeker->save();
            Session::flash('success', 'Feedback thành công');
            return redirect()->route('company.detail-candidate.index', ['id' => $id]);
        } else {
            Session::flash('error', 'Bạn đã feedback ứng viên này rồi');
            return Redirect()->route('company.feedback', ['id' => $id]);
        }
    }

}
