<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateSkill extends Model
{

    public $table = 'candidate_skills';
    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'skill',
    ];
}
