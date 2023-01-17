<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortlistCompany extends Model
{
    use HasFactory;
    protected $table = 'shortlist_company';
    protected $fillable = [
        'id',
        'company_id',
        'candidate_id',
        'created_at',
        'updated_at',
    ];
}
