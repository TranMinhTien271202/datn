<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortlisted extends Model
{
    use HasFactory;
    protected $table = 'shortlisted';
    protected $fillable = [
        'id',
        'job_post_id',
        'candidate_id',
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
