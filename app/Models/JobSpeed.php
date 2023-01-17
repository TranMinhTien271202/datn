<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSpeed extends Model
{
    use HasFactory;
    protected $table = 'job_speed';
    protected $fillable = [
        'job_post_id',
        'seeker_id',
        'status',
        'time'
    ];
    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function job()
    {
        return $this->belongsToMany(job::class);
    }
}
