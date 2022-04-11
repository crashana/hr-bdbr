<?php

namespace App\Traits;

use App\Models\Media\Media;
use App\Services\Media\MediaService;
use Illuminate\Support\Facades\App;

trait HasMediaTrait
{

    public function media()
    {
        return $this->morphMany(Media::class, 'media');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {

            foreach ($data->media as $media) {
                App::make(MediaService::class)->delete($media->id);
            }
        });
    }
}
