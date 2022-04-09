<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateStatus extends Model
{

    public $table = 'candidates';
    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'is_current',
        'status',
        'comment',
    ];

}
