<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    use HasFactory;
    protected $table = 'seeker_profile';
    protected $fillable = [
        'candidate_id',
        'firt_name',
        'last_name',
        'name',
        'position_candidate',
        'coin',
        'pasth_cv',
        'created_at',
        'updated_at',
    ];
}
