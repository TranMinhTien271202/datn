<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Company  extends Authenticatable
{
    use HasFactory;
    protected $table = "companies";
    protected $fillable = ['id', 'name', 'company_name', 'address', 'company_model', 'working_time',
    'phone', 'email', 'password', 'logo', 'link_web', 'coin', 'tax_code', 'team', 'image_paper',
    'status', 'about', 'founded_in','map','career', 'created_at', 'updated_at'];

    public function companyDetail($id)
    {
        $query = DB::table($this->table)
            ->where('id', '=', $id);
        $lists = $query->first();
        return $lists;
    }

    // lưu tạo
    public function saveAdd($params) {
        $data = array_merge($params['cols'], [
            'password' => Hash::make($params['cols']['password']),
        ]);
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
