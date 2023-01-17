<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCompany extends Model
{
    use HasFactory;
    protected $table = "feedback_company";
    protected $fillable = [
        'id', 'candidate_id', 'company_id', 'rate', 'comment', 'satisfied', 'like_text', 'unlike_text', 'improve', 'unsatisfie', 'created_at', 'updated_at'
    ];
}
