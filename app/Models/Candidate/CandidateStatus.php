<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    public $table = 'candidates';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'min_salary',
        'max_salary',
        'linkedin_url',
    ];

    
}
