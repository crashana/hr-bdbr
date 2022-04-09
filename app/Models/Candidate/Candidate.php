<?php

namespace App\Models\Locales;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Locales extends Model
{
    use LogsActivity;

    public $table = 'locales';
    public $timestamps = false;

    protected $fillable = [
        'locale',
        'title',
        'active',
        'default',
    ];

    protected static $logFillable = true;
}
