<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\Payment_vnpay;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index() {
        $this->v['countCandidate'] = Candidate::all();
        $this->v['countCompany'] = Company::all();
        $this->v['countCV'] = SeekerProfile::all();
        $this->v['countSkill'] = Skill::all();
        $this->v['countUser']= User::all();
        $this->v['countMajor'] = Major::all();
        $this->v['countPendingImagePaper'] = Company::where('status', 0)->get()->toArray();
        $this->v['countActiveImagePaper'] = Company::where('status', 1)->get()->toArray();
        $this->v['countBlockImagePaper'] = Company::where('status', 2)->get()->toArray();
        $totalMoney = Payment_vnpay::getMoneyMonthly();
        $this->v['months'] = $totalMoney['time'];
        $this->v['totalMoneyMonth'] =  $totalMoney['money'];
        return view('admin.dashboard', $this->v);
    }
}

