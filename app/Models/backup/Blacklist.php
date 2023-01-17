<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blacklist extends Model
{
    use HasFactory;
    protected $table = 'black_list';
    protected $fillable = ['id','candidate_id','company_id','deleted_at', 'status', 'created_at', 'updated_at'];


    public function loadList($param = []){
        $query = DB::table($this->table)
            ->select($this->fillable);
        $list = $query->paginate(10);
        // search
        if($key = request()->key);
            $query = DB::table($this->table)
                ->select($this->fillable)
                ->where('id','like','%' . $key . '%');
            $list = $query->paginate(10);
            
        return $list;
    }
}
