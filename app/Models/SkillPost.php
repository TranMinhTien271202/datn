<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillPost extends Model
{
    use HasFactory;
    protected $table = 'skill_posts';
    protected $fillable = [
        'post_id',
        'seeker_id',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function job()
    {
        return $this->belongsToMany(JobPost::class);
    }
}
