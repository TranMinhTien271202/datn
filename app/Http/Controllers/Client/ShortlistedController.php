<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Major;
use App\Models\Shortlist;
use Illuminate\Http\Request;

class ShortlistedController extends Controller
{

    public function shortlisted(Request $request, $id)
    {
        if (auth('candidate')->check()) {
            $id_user = auth('candidate')->user()->id;
            $shortlisted = new Shortlist;
            $shortlisted->job_post_id = $request->id;
            $shortlisted->candidate_id = $id_user;
            $shortlisted->save();
            return response()->json(['status'=>"success",'shortlistedId'=>$shortlisted->id]);
        }else {
            return Redirect()->route('candidate.login');
        }
    }
    public function shortlisted_job()
    {
        $data = [];
        $job_short = [];
        $major_job = [];
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $data = Shortlist::where('candidate_id', $id)->paginate(5);
            if (!empty($data)) {
                foreach ($data as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = JobPost::where('id', $id_post)->first();
                    $major_job[$id_post] = Major::where('id',$job_short[$id_post]->major_id)->pluck('name')->toArray();
                }
            }
            $maJor = Major::all();
            return view('client.candidate.shortlisted-job', compact('data', 'job_short', 'maJor','major_job'));
        }else {
            return Redirect()->route('candidate.login');
        }
    }
    public function shortlisted_company()
    {
        $data = [];
        $company_short = [];
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $data = Shortlist::where('candidate_id', $id)->take(6)->get();
            if (!empty($data)) {
                foreach ($data as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = JobPost::where('id', $id_post)->first();
                }
            }
            $maJor = Major::all();
            return view('client.company.shortlisted-company', compact('data', 'job_short', 'maJor'));
        }else {
            return Redirect()->route('candidate.login');
        }
    }
    public function destroy($id)
    {
        if (auth('candidate')->check()){
            Shortlist::destroy($id);
            return response()->json(['status'=>"success"]);
        }else {
            return Redirect()->route('candidate.login');
        }
    }
}
