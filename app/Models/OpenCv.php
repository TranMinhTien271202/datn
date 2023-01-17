<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenCv extends Model
{
    use HasFactory;
    protected $table = 'open_cv';
    protected $fillable = ['id','seeker_id','company_id', 'status', 'created_at', 'updated_at'];
}
