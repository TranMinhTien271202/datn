<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback';
    protected $fillable = [
        'id',
        'candidate_id',
        'company_id',
        'rate',
        'title',
        'satisfied',
        'unsatisfied',
        'improve',
        'like_text',
        'is_candidate',
        'created_at',
        'updated_at',
        'is_reality'
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
    public function listFeedback($id){
        $query=DB::table($this->table)
        ->select($this->fillable)
        ->where('company_id', $id);
        $list=$query->get();
        return $list;

    }
    
    public function getFeedbackCompany($id){
        $query=DB::table($this->table)
        ->select($this->fillable)
        ->where('company_id', $id)
        ->where('is_candidate', 0);
        $list=$query->paginate(5);
        return $list;

    }

    public function getCountFeedbackCompany($id){
        $query=DB::table($this->table)
        ->select($this->fillable)
        ->where('company_id', $id)
        ->where('is_candidate', 0);
        $list=$query->count();
        return $list;

    }

}
