<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    public $table = 'candidates';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'min_salary',
        'max_salary',
        'linkedin_url',
    ];
    protected $appends = ['current_status'];

    public function skills()
    {
        return $this->hasMany(CandidateSkill::class);
    }

    public function statuses()
    {
        return $this->hasMany(CandidateStatus::class)
            ->orderBy('created_at', 'DESC');
    }

    public function getCurrentStatusAttribute()
    {
        return $this->statuses->where('is_current', 1);
    }
}
