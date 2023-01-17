<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;
    protected $table = 'job_type';
    protected $fillable = [
        'name',
        'description',
        'job_post_id',
        'created_at',
        'updated_at',
        'icon',
    ];
}
