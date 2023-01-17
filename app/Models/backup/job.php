<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;
    protected $table = 'job_posts';
    protected $fillable = [
        'company_id',
        'title',
        'meta_description',
        'description',
        'remote',
        'min_salary',
        'max_salary',
        'requirement',
        'start_date',
        'end_date',
        'experience',
        'status'
    ];
    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}
