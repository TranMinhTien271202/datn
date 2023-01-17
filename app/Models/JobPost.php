<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToManyRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobPost extends Model
{
    use HasFactory;
    protected $table = "job_posts";
    protected $fillable = [
        'id', 'company_id', 'title', 'major_id', 'description',  'level',   'min_salary', 'max_salary',  'requirement',
        'start_date', 'end_date', 'area', 'address',
        'experience', 'status',  'created_at',    'updated_at',    'deleted_at',    'amount', 'type_work', 'gender',  'benefits'
    ];
    public $timestamps = true;
    public function getStatusAttribute($value)
    {
        $customerStatus = null;
        switch ($value) {
            case config('custom.job_post_status.active'):
                $customerStatus = 'Hiện thị';
                break;
            case config('custom.job_post_status.block'):
                $customerStatus = 'Hết hạn';
                break;
            default:
                $customerStatus = 'Hiện thị';
                break;
        }

        return $customerStatus;
    }
    // public function jobPostActivities(){
    //     return $this->belongsTo(jobPostActivities::class,'job_post_id');
    // }
    public function activities()
    {
        return $this->hasMany(JobPostActivities::class, 'job_post_id')->selectRaw('job_post_id,count(*) as count')->where('is_function',0)->groupBy('job_post_id');
    }
    public function seekerProfiles(){
        return $this->belongsToMany(SeekerProfile::class, 'job_post_activities', 'job_post_id', 'seeker_id')->withPivot('is_see');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function skills(){
        return $this->belongsToMany(Skill::class, 'skill_posts', 'post_id','skill_id');
    }
}
