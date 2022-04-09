<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateStatus extends Model
{

    public $table = 'candidate_statuses';
    public $timestamps = true;

    protected $fillable = [
        'candidate_id',
        'is_current',
        'status',
        'comment',
    ];
}
