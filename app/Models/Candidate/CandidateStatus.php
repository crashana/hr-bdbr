<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateStatus extends Model
{
    const STATUSES = [
        'Initial',
        'First Contact',
        'Interview',
        'Tech Assignment',
        'Rejected',
        'Hired',
    ];

    public $table = 'candidate_statuses';
    public $timestamps = true;

    protected $fillable = [
        'candidate_id',
        'is_current',
        'status',
        'comment',
    ];

    protected $appends = ['created'];

    public function getCreatedAttribute()
    {
        return formatDate($this->created_at);
    }
}
