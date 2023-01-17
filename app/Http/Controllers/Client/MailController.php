<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Candidate;
use App\Models\JobPost;
use App\Models\JobPostActivities;
use App\Models\Major;
use App\Models\SeekerProfile;
use App\Models\Skill;
use App\Models\SkillPost;
use App\Models\SkillSeeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        if (auth('candidate')->check()) {
            $subject = auth('candidate')->user()->id;
            $seeker = SeekerProfile::where('candidate_id', $subject)->where('is_active', 1)->first();
            if (!empty($seeker)) {
                $bitcoin = auth('candidate')->user()->coin;
                $candidate = Candidate::where('status', 1)->where('id', $subject)->first();
                $job_atv = JobPostActivities::where('seeker_id', $seeker->id)->get();
                $today = strtotime(Carbon::now());
                $coin = $bitcoin;
                $date = date('Y/m/d', time());
                $jobspeed = JobPostActivities::where('seeker_id', $seeker->id)->whereDate('created_at', $date)->where('is_function', 1)->first(); // hàm sử lý thời gian
                $major = $seeker->major_id;
                $skill_seeker = SkillSeeker::where('seeker_id', $seeker->id)->first();
                $path_cv = $seeker->path_cv;
                $tien = 30;
                $ad = Skill::join('skill_seekers', 'skill_seekers.skill_id', '=', 'skills.id')
                    ->join('skill_posts', 'skill_posts.skill_id', '=', 'skills.id')
                    ->join('job_posts', 'skill_posts.post_id', '=', 'job_posts.id')
                    ->where(function ($q) {
                        $subject = auth('candidate')->user()->id;
                        $seeker = SeekerProfile::where('candidate_id', $subject)->first();
                        $skill_seeker = SkillSeeker::where('seeker_id', $seeker->id)->pluck('skill_id')->toArray();
                        if ($seeker->major_id != null) {
                            $q->where('job_posts.major_id', $seeker->major_id);
                        }
                        if ($skill_seeker != []) {
                            $q->whereIn('skill_seekers.skill_id', $skill_seeker);
                        }
                    })
                    ->distinct()
                    ->select('job_posts.*')
                    ->get();
                if (!empty($seeker) && $major != null && $path_cv != null && $skill_seeker != null) {
                    if ($coin - $tien < 0) {
                        return back()->with('error', 'Tài Khoản Của Bạn Không Đủ Số Dư Vui Lòng Nạp Thêm Tiền !');
                    } elseif (!empty($jobspeed)) {
                        return back()->with('error', 'Hôm Nay Bạn Đã Sử Dụng Phương Thức Này Rồi Vui Lòng Quay Lại Vào Ngày Mai !');
                    } elseif (count($ad) == 0) {
                        return back()->with('warning', 'Không Có Job Nào Phù Hợp!');
                    } else {
                        foreach ($ad as $item) {
                            $end_time = strtotime($item->end_date);
                            $total = $end_time - $today;
                            $day = floor($total / 60 / 60 / 24);
                            if ($day > 0) {
                                $email = $item->company->email;
                                $speed = new JobPostActivities();
                                $company_name = $item->company->company_name;
                                $post_name = $item->title;
                                Mail::to($email)->send(new SendMail($subject, $company_name,$post_name));
                                $speed->job_post_id = $item->id;
                                $speed->seeker_id = $seeker->id;
                                $speed->is_function = 1;
                                $speed->company_id = $item->company_id;
                                foreach ($job_atv as $rows) {
                                    if ($rows->company_id != $item->company_id && $rows->seeker_id != $seeker->id) {
                                        $speed->is_see = 0;
                                    } elseif ($rows->company_id == $item->company_id && $rows->seeker_id == $seeker->id && $rows->is_see == 0) {
                                        $speed->is_see = 0;
                                    } elseif ($rows->company_id == $item->company_id && $rows->seeker_id == $seeker->id && $rows->is_see == 1) {
                                        $speed->is_see = 1;
                                    }
                                }
                                $speed->save();
                            }
                        }
                        $candidate->update([
                            'coin' => $coin - $tien,
                        ]);
                        updateProcess(auth('candidate')->user()->id, "- $tien coin sử dụng chức năng tìm việc nhanh", $tien, 0, 1);
                        return redirect()->route('speedapply')->with('success', 'Tìm Kiếm Thành Công');
                    }
                } elseif (!empty($seeker) && $major == "" && $path_cv != null && $skill_seeker == "") {
                    $jobpost = SkillPost::join('job_posts', 'skill_posts.post_id', '=', 'job_posts.id')->join('skills', 'skill_posts.skill_id', '=', 'skills.id')
                        ->where(function ($q) use ($request, $job_atv) {
                            $major = $request->major;
                            $skill = $request->skill;
                            if (!empty($skill)) {
                                $q->where('skills.id', '=', $skill);
                            }
                            foreach ($job_atv as $row) {
                                if (!empty($major)) {
                                    $q->where('job_posts.major_id', '=', $major);
                                }
                            }
                        })
                        ->distinct()
                        ->select('job_posts.*')
                        ->get();
                    if ($coin - 30 < 0) {
                        return back()->with('error', 'Tài Khoản Của Bạn Không Đủ Số Dư Vui Lòng Nạp Thêm Tiền !');
                    }
                    if ($major == "" && $request->major == null && $request->skill == null && $request->type == null) {
                        return back()->with('error', 'Bạn Chưa Tạo cv trên hệ thống vui lòng chọn chuyên ngành bạn muốn tìm!');
                    } elseif (!empty($jobspeed)) {
                        return back()->with('error', 'Hôm Nay Bạn Đã Sử Dụng Phương Thức Này Rồi Vui Lòng Quay Lại Vào Ngày Mai !');
                    } elseif (!isset($jobpost)) {
                        return back()->with('warning', 'Không Có Job Nào Phù Hợp!');
                    } else {
                        // dd($request->skill);
                        $job = SkillPost::join('job_posts', 'skill_posts.post_id', '=', 'job_posts.id')
                            ->join('skills', 'skill_posts.skill_id', '=', 'skills.id')
                            ->where(function ($q) use ($request, $job_atv) {
                                $major = $request->major;
                                $skill = $request->skill;
                                $type = $request->type;
                                foreach ($job_atv as $row) {
                                    $q->where('job_posts.id', '!=', $row->job_post_id);
                                    if (!empty($major)) {
                                        $q->where('job_posts.major_id', '=', $major);
                                    }
                                }
                                if (!empty($skill)) {
                                    $q->whereIn('skill_posts.skill_id', $skill);
                                }
                                if (!empty($type)) {
                                    $q->where('job_posts.type_work', '=', $type);
                                }
                            })
                            ->distinct()
                            ->select('job_posts.*')
                            ->get();
                        foreach ($job as $item) {
                            $end_time = strtotime($item->end_date);
                            $total = $end_time - $today;
                            $day = floor($total / 60 / 60 / 24);
                            if ($day > 0) {
                                $email = $item->company->email;
                                $speed = new JobPostActivities();
                                $company_name = $item->company->company_name;
                                $post_name = $item->title;
                                Mail::to($email)->send(new SendMail($subject, $company_name,$post_name));
                                $speed->job_post_id = $item->id;
                                $speed->seeker_id = $seeker->id;
                                $speed->is_function = 1;
                                $speed->company_id = $item->company_id;
                                foreach ($job_atv as $rows) {
                                    if ($rows->company_id != $item->company_id && $rows->seeker_id != $seeker->id) {
                                        $speed->is_see = 0;
                                    } elseif ($rows->company_id == $item->company_id && $rows->seeker_id == $seeker->id && $rows->is_see == 0) {
                                        $speed->is_see = 0;
                                    } elseif ($rows->company_id == $item->company_id && $rows->seeker_id == $seeker->id && $rows->is_see == 1) {
                                        $speed->is_see = 1;
                                    }
                                }
                                $speed->save();
                            }
                        }
                        $candidate->update([
                            'coin' => $coin - $tien,
                        ]);
                        updateProcess(auth('candidate')->user()->id, "- $tien coin sử dụng chức năng tìm việc nhanh", $tien, 0, 1);
                        return redirect()->route('speedapply')->with('success', 'Tìm Kiếm Thành Công');
                    }
                } else {
                    return back()->with('error', 'Bạn chưa tạo cv trên hệ thống vui lòng tạo cv để sử dụng tính năng này!');
                }
            } else {
                return back()->with('error', 'Vui lòng tạo hoặc tải cv của bạn lên hệ thống để sử dụng chức năng!');
            }
        } else {
            return back()->with('error', 'Vui lòng đăng nhập để sử dụng chức năng!');
        }
    }
    public function jobspeed()
    {
        $maJor = Major::all();
        $skill = Skill::all();
        $skill_seeker = [];
        $seeker = [];
        $major = [];
        if (auth('candidate')->check()) {
            $user_id = auth('candidate')->user()->id;
            $seeker = SeekerProfile::where('candidate_id', $user_id)->where('is_active', 1)->first();
            if (!empty($seeker)) {
                $skill_seeker = SkillSeeker::where('seeker_id', $seeker->id)->first();
            }
        }
        return view('email.job-speed', compact('maJor', 'skill', 'seeker', 'major', 'skill_seeker'));
    }
    public function speedapply()
    {
       if(auth('candidate')->check()){
            $id_user = auth('candidate')->user()->id;
            $seeker = SeekerProfile::where('candidate_id', $id_user)->first();
            $data = [];
            $job_applied = [];
            if (!empty($seeker)) {
                $job_applied = [];
                $data = JobPostActivities::where('seeker_id', $seeker->id)->where('is_function', 1)->paginate(8);
                if (!empty($data)) {
                    foreach ($data as $item) {
                        $id_post = $item->job_post_id;
                        $job_applied[$id_post] = JobPost::where('id', $id_post)->first();
                    }
                }
            }
            $maJor = Major::all();
            return view('client.job.job-speed', compact('data', 'job_applied', 'maJor'));
       }else {
            return Redirect()->route('candidate.login');
        }
    }
}
