<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // company
    public function __construct()
    {
        $this->v = [];
    }
    public function indexc($id){
        $list = Feedback::where('company_id',$id)
                                ->where('is_candidate',0)
                                ->get();
        $count = count($list);

        if($count == 0 ){
            $this->v['feed']=Feedback::where('is_candidate',0)->get();
            $this->v['list'] = Company::paginate(9);
            $this->v['title'] = "Danh sách công ty";
            return view("admin.companies.index", $this->v);
        }else{
            foreach($list as $u){
                $a[]=$u->candidate_id;
            }
            foreach($a as $b=>$c){
                $can[] = Candidate::where('id',$c)->paginate(9);
            }
    
            $name = Company::where('id',$id)->first();
            $title = "Danh sách bài Feedback của công ty: $name->company_name";
            return view('admin.feedback.company.index',compact('list','can','title'));
        }
    }
    // candidate
    public function index($id){
        $list = Feedback::where('candidate_id',$id)
                                ->where('is_candidate',1)
                                ->get();
        $count = count($list);
        if($count == 0){
            $candidate = new Candidate();
            $this->v['list'] = Candidate::paginate(9);
            $this->v['title'] = "Danh sách ứng viên";
            $this->v['feed']=Feedback::where('is_candidate',1)->get();
            return view('admin.candidate.index', $this->v);
        }else{
            foreach($list as $u){
                $a[]=$u->company_id;
            }
            foreach($a as $b=>$c){
                $can[] = Company::where('id',$c)->paginate(9);
            }
    
            $name = Candidate::where('id',$id)->first();
            $title = "Danh sách các bài Feedback dành cho ứng viên: $name->name";
            return view('admin.feedback.candidate.index',compact('list','can','title'));
        }
    }
    public function destroy($ida, $id)
    {
        Feedback::where('id', $id)->delete();
        return response()->json(['success'=>'Xóa thành công!']);
    }
}
