<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\FeedbackRequest;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Feedback;
use App\Models\JobPost;
use App\Models\Major;
use App\Models\Shortlist;
use App\Models\ShortlistCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $job = [];
        $data = Company::where('status', 1)->where(function ($q) use($request){
            if (!empty($request->search)) {
                $q->orwhere('company_name', 'LIKE', '%' . $request->search . '%');
            }
            if (!empty($request->address)) {
                $q->orwhere('address', 'LIKE', '%' . $request->address . '%');
            }
            if (!empty($request->size)) {
                $q->where('team', '=', $request->size);
            }
        })->paginate(10);
        foreach ($data as $item) {
            $job[$item->id] = JobPost::where('company_id', $item->id)->get();
        }
        $workingTime = [
            6 => '6 tiếng',
            7 => '7 tiếng',
            8 => '8 tiếng',
        ];
        $team = [
            50 => '50-100 người',
            100 => '100-150 người',
            200 => '200-250 người',
            300 => '300-350 người',
            500 => '500-1000 người',
        ];
        $maJor = Major::all();
        return view('client.company.company', compact('data', 'job', 'maJor','workingTime','team'));
    }
    public function detail(Request $request, $id)
    {
        $job_short = [];
        $company_detail = Company::where('id', $id)->first();
        $company_job = JobPost::where('company_id', $company_detail->id)->paginate(3);
        $query = new Feedback();
        $data = $query->getFeedbackCompany($id);
        $sum = $query->getCountFeedbackCompany($id);
        $u = 0;
        foreach ($data as $list => $item) {
            $u += $item->rate;
        }
        if ($sum != 0 && $sum != null) {
            $average = number_format($u / $sum, 1);
        } else {
            $average = null;
        }
        $maJor = Major::all();

        $idCompanyShort = [];
        if (auth('candidate')->check()) {
            $id_user = auth('candidate')->user()->id;
            $dataShort = ShortlistCompany::where('candidate_id', $id_user)->get();
            if (!empty($dataShort)) {
                foreach ($dataShort as $item) {
                    $idCompanyShort[$item->company_id] = $item;
                }
            }
        }
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $data_short = Shortlist::where('candidate_id', $id)->get();
            if (!empty($data_short)) {
                foreach ($data_short as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = $item;
                }
            }
        }
        $workingTime = [
            6 => '6 tiếng',
            7 => '7 tiếng',
            8 => '8 tiếng',
        ];
        $team = [
            50 => '50-100 người',
            100 => '100-150 người',
            200 => '200-250 người',
            300 => '300-350 người',
            500 => '500-1000 người',
        ];
        if ($request->ajax()) {
            return view('client.company.job-related',compact('team','workingTime','company_detail', 'company_job', 'maJor', 'average', 'sum', 'idCompanyShort', 'job_short'));
        }
        return view('client.company.company-detail', compact('team','workingTime','company_detail', 'company_job', 'maJor', 'average', 'sum', 'idCompanyShort', 'job_short'));
    }
    public function filter(Request $request)
    {
        $keyword = $request->keyword;
        $address = $request->address;
        $job = [];
        $data = Company::where('name', 'like', '%' . $keyword . '%')->Where('address', 'like', '%' . $address . '%')->get();
        $maJor = Major::all();
        foreach ($data as $item) {
            $job = JobPost::where('company_id', $item->id)->get();
        }
        return view('client.company.company', compact('data', 'maJor', 'job'));
    }
    public function feedback($id)
    {
        $company_detail = company::where('id', $id)->first();
        $company_job = JobPost::where('company_id', $company_detail->id)->get();
        $maJor = Major::all();
        return view('client.company.feedback', compact('company_detail', 'company_job', 'maJor'));
    }
    public function saveFeedback(FeedbackRequest $request, $id)
    {
        $id_user = auth('candidate')->user()->id;
        $feedback = new Feedback();
        $data = Feedback::where('candidate_id', $id_user)->where('company_id', $id)->get();
        $a = count($data);
        if ($a == 0) {
            $feedback->rate = $request->rate;
            $feedback->candidate_id = $id_user;
            $feedback->company_id = $id;
            $feedback->title = $request->title;
            $feedback->satisfied = $request->satisfied;
            $feedback->unsatisfied = $request->unsatisfied;
            $feedback->like_text = $request->like_text;
            $feedback->improve = $request->improve;
            $feedback->is_candidate = "0";
            $feedback->save();
            Session::flash('success', 'Feedback thành công');
            return redirect()->route('company-detail', ['id' => $id]);
        } else {
            Session::flash('error', 'Tài khoản của bạn đã từng gửi Feedback đến công ty');
            return Redirect()->route('feedback', ['id' => $id]);
        }
    }

    public function getRate(Request $request, $id){
        $job_short = [];
        $company_detail = Company::where('id', $id)->first();
        $company_job = JobPost::where('company_id', $company_detail->id)->paginate(3);
        $query = new Feedback();
        $data = $query->getFeedbackCompany($id);
        $sum =  $query->getCountFeedbackCompany($id);
        $tong = $sum;
        $u = 0;
        foreach ($data as $list => $item) {
            $u += $item->rate;
        }
        if ($sum != 0 && $sum != null) {
            $average = number_format($u / $sum, 1);
        } else {
            $average = null;
        }
        $maJor = Major::all();

        $idCompanyShort = [];
        if (auth('candidate')->check()) {
            $id_user = auth('candidate')->user()->id;
            $dataShort = ShortlistCompany::where('candidate_id', $id_user)->get();
            if (!empty($dataShort)) {
                foreach ($dataShort as $item) {
                    $idCompanyShort[$item->company_id] = $item;
                }
            }
        }
        if (auth('candidate')->check()) {
            $id = auth('candidate')->user()->id;
            $data_short = Shortlist::where('candidate_id', $id)->get();
            if (!empty($data_short)) {
                foreach ($data_short as $item) {
                    $id_post = $item->job_post_id;
                    $job_short[$id_post] = $item;
                }
            }
        }
        $workingTime = [
            6 => '6 tiếng',
            7 => '7 tiếng',
            8 => '8 tiếng',
        ];
        $team = [
            50 => '50-100 người',
            100 => '100-150 người',
            200 => '200-250 người',
            300 => '300-350 người',
            500 => '500-1000 người',
        ];
        if ($request->ajax()) {
            return view('client.company.rate_paginate',compact('data','tong','workingTime','company_detail', 'company_job', 'maJor', 'average', 'sum', 'idCompanyShort', 'job_short'));
        }
        return view('client.company.list-rate', compact('data','tong','team','workingTime','company_detail', 'company_job', 'maJor', 'average', 'sum', 'idCompanyShort', 'job_short'));
    }
}
