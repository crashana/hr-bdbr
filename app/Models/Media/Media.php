<?php

namespace App\Models\Media;

use App\Scopes\OrderingScope;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    public $table = 'media';
    public $timestamps = true;


    protected $fillable = [
        'media_type',
        'media_id',
        'collection_name',
        'path',
        'name',
        'file_name',
        'label',
        'mime_type',
        'extension',
        'ord',
    ];

    protected $hidden = [
        'media_type',
        'media_id',
        'mime_type',
        'extension',
        'created_at',
        'updated_at'
    ];

    public function media()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::addGlobalScope(new OrderingScope);
    }
}
