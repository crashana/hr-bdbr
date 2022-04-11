<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Model;

class MediaResponsive extends Model
{

    public $table = 'media_responsive';
    public $timestamps = false;


    protected $fillable = [
        'id',
        'media_id',
        'size',
        'path',
        'file_name',
        'watermarked',
        'webp',
    ];



    protected $hidden = [
        'watermarked'
    ];
}
