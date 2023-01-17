<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class Candidate extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'candidates';
    protected $fillable = [
        'id', 'name', 'avatar', 'email', 'password', 'phone', 'address', 'gender',
        'birthday', 'coin', 'deleted_at', 'status', 'created_at', 'updated_at','google_id','type','verify_time','token'
    ];
    // lưu tạo
    public function saveAdd($params)
    {
        $data = array_merge($params['cols'], [
            'password' => Hash::make($params['cols']['password']),
        ]);
        $res = DB::table($this->table)->insert($data);
        return $res;
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    public function seeker()
    {
        return $this->belongsTo(SeekerProfile::class);
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
                $data = array_merge($params['cols'], [
                    'password' => Hash::make($params['cols']['password']),
                ]);
            }
        }
        $res = DB::table($this->table)
            ->where('id', '=', $params['cols']['id'])
            ->update($data);
        return $res;
    }

    public function saveUpdateAdmin($params)
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

    public function saveUpdateProfile($params)
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
