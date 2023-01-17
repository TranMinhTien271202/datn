<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Candidate extends Model
{
    use HasFactory;
    protected $table = 'candidates';
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'phone',
        'address',
        'position',
        'gender',
        'city',
        'coin',
        'link_git',
        'languages',
        'description',
        'facebook',
        'zalo',
        'twitter',
        'instagram',
        'age',
        'country',
        'experience',
        'education_levels',
        'status'
    ];
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
}
