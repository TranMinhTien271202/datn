<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Skill_other extends Model
{
    use HasFactory;
    protected $table = 'skill_others';
    protected $fillable = [
        'id',
        'seeker_id',
        'title',
        'description',
        'created_at',
        'updated_at'
        ];

    // lưu tạo
    public function saveAdd($params) {
        $data = $params['cols'];
        $res = DB::table($this->table)->insert($data);
        return $res;
    }

    // lưu cập nhật
    public function saveUpdate($params) {
        if(empty($params['cols']['id'])) {
            Session::flash('error', 'Không xác định bản cập nhật');
            return null;
        }
        $data = [];
        foreach($params['cols'] as $colName => $val) {
            if($colName == 'id') continue;
            if(in_array($colName, $this->fillable)) {
                $data[$colName] = (strlen($val) == 0) ? null : $val;
            }
        }
        $res = DB::table($this->table)
        ->where('id', '=', $params['cols']['id'])
        ->update($data);
        return $res;
    }
}
