<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillSeeker extends Model
{
    use HasFactory;
    protected $table = 'skill_seekers';
    protected $fillable = ['id','seeker_id','skill_id', 'created_at', 'updated_at'];

    public function getNameSkill()
    {
        return $this->belongsTo(Skill::class,'skill_id','id');
    }
}
