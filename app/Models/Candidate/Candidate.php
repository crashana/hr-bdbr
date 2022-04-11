<?php

namespace App\Models\Candidate;

use App\Models\Media\Media;
use App\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    use HasMediaTrait;

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
    protected $with = ['skills', 'documents'];

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
        $status = $this->statuses->where('is_current', 1)->last();
        return $status ? $status->status : '';
    }


    public function documents()
    {
        return $this->morphMany(Media::class, 'media')
            ->where('collection_name', 'document');
    }
}
