<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = ['id', 'name', 'description', 'created_at', 'updated_at'];

    public function saveAdd($params)
    {
        $data = array_merge($params['cols']);
        $res = DB::table($this->table)->insert($data);
        return $res;
    }

    // lưu cập nhật
    public function saveUpdate($params)
    {
        if (empty($params['cols']['id'])) {
            Session::flash('error', 'Không xác định bản cập nhật');
            return null;
        }
        $data = [];
        foreach ($params['cols'] as $colName => $val) {
            if ($colName == 'id') continue;
            if (in_array($colName, $this->fillable)) {
                $data[$colName] = (strlen($val) == 0) ? null : $val;
            }
        }
        $res = DB::table($this->table)
            ->where('id', '=', $params['cols']['id'])
            ->update($data);
        return $res;
    }
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'skill_posts', 'skill_id', 'post_id');
    }
    public function getIdSkillSeeker()
    {
        return $this->belongsTo(SkillSeeker::class, 'id', 'skill_id');
    }
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
