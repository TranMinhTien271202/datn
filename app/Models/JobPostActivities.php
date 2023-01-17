<?php

namespace App\Models;

use App\Models\JobPostActivities as ModelsJobPostActivities;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobPostActivities extends Model
{
    use HasFactory;
    protected $table = 'job_post_activities';
    protected $fillable = [
        'job_post_id',
        'seeker_id',
        'company_id',
        'created_at',
        'updated_at',
        'time',
        'is_function',
        'introduct'
    ];
    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function job_post()
    {
        return $this->belongsTo(JobPost::class);
    }
    public function job()
    {
        return $this->belongsToMany(JobPost::class);
    }
    public function seeker_profile()
    {
        return $this->belongsTo(SeekerProfile::class,'seeker_id');
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function getListCandidate($post_id){
       $jobActive = DB::table($this->table)->where('job_post_id',$post_id)->get();
       $data = $jobActive;
       $selectShow = ['candidates.name','candidates.avatar','candidates.email','candidates.phone'];
       foreach($jobActive as $key => $job){
            $seeker_id =  DB::table('seeker_profiles')->select($selectShow)->join('candidates','candidates.id','=','seeker_profiles.candidate_id')->where('seeker_profiles.id',$job->seeker_id)->first();
            $data[$key]->infoCandidate = $seeker_id;
       }
       return $data;
    }
    public static function getCadidate($request,$company_id){
        if (!empty($request->time_filter)) {
            if ($request->time_filter == 28) {
                $from =  date_format(date_modify(now(), "-28 days"),"Y-m-d");
            }else{
                $from =  date_format(date_modify(now(), "-7 days"),"Y-m-d");
            }
        }else{
            $from =  date_format(date_modify(now(), "-7 days"),"Y-m-d");
        }
        $to =  date_format(now(),"Y-m-d");
        $totalApplied = DB::table('job_post_activities')
                ->where('company_id',$company_id)->whereBetween('created_at', [$from, $to])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as applied'))
                ->groupBy('date')
                ->get()
                ->toArray();
        $model = new ModelsJobPostActivities();
        $dateArray = $model->getDatesFromRange($from,$to);
        $arrayShow = [];
        foreach ($dateArray as $key => $value) {
            $data = [];
            foreach($totalApplied as $val){
                $data['date'] =date('d-m-Y',strtotime($value)) ;
                if ($value == $val->date) {
                    $data['total'] = $val->applied;
                    break;
                }else{
                    $data['total'] = 0;
                }
                // if($data['total']!=0){
                //     dd([$val->date, $data['total']]);
                // }
            }
            array_push($arrayShow,$data);
        }
       return $arrayShow;
    }
    public function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }
        return $array;
    }
}
