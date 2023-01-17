<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Candidate;
use App\Models\Company;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\TryCatch;

class LoginGoogleController extends Controller
{
    public function getGoogleLoginClient(Request $request)
    {
        $arrayUrl = explode('/',session()->all()['_previous']['url']);
        $checkTypeAccount = in_array('company',$arrayUrl);
        Session::flash('typeAccount',$checkTypeAccount);
        if (Session::has('job_id')) {
            Session::flash('job_id',Session::get('job_id'));
        }
        return Socialite::driver('google')->redirect();
    }

    public function loginClientCallback(Request $request)
    {
        $user = Socialite::driver('google')->stateless()->user();
        if (Session::get('typeAccount')) {
            $this->handleCompany($user);
            return redirect()->route('company.home');
        }else{
           $this->handleCandidate($user);
           if (Session::has('job_id') ) {
                return redirect()->route('job-detail',Session::get('job_id'));
            }else{
                return redirect()->route('index');
            }
        }
    }
    public function handleCandidate($user){
        $checkcandidate = Candidate::where('google_id',$user->id)->orWhere('email',$user->email)->first();
        if (!empty($checkcandidate)) {
            auth('candidate')->login($checkcandidate);
            Session::flash('success',"Đăng nhập thành công");
        }else{
            
            try {
                $candidate =  Candidate::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'google_id' => $user->id,
                ]);
                auth('candidate')->login($candidate);
                Session::flash('success',"Đăng nhập thành công");
            } catch (\Throwable $th) {
                Session::flash('error',"Đăng nhập thất bại" . $th->getMessage());
            }
        }
    }
    public function handleCompany($user){
        $checkcompany = Company::where('google_id',$user->id)->first();
        if (!empty($checkcompany)) {
            auth('company')->login($checkcompany);
            Session::flash('success',"Đăng nhập thành công");
        }else{
            try {
                $company =  Company::create([
                    'company_name' => $user->name,
                    'email' => $user->email,
                    'logo' => $user->avatar,
                    'google_id' => $user->id,
                ]);
                auth('company')->login($company);
                Session::flash('success',"Đăng nhập thành công");
            } catch (\Throwable $th) {
                Session::flash('error',"Đăng nhập thất bại");
            }
        }
    }
}
