<?php

namespace App\Repositories\Media;

use App\Models\Media\Media;
use Symfony\Component\HttpFoundation\ParameterBag;

class MediaRepo implements MediaRepoInterface
{

    public function get(int $id): Media
    {
        return Media::findOrFail($id);
    }

    public function create(ParameterBag $data): Media
    {
        return Media::create([
            'collection_name' => $data->get('collection_name'),
            'path' => $data->get('path'),
            'name' => $data->get('name'),
            'file_name' => $data->get('file_name'),
            'mime_type' => $data->get('mime_type'),
            'extension' => $data->get('extension'),
            'ord' => $data->get('ord'),
        ]);
    }


    public function delete(int $id): bool
    {
        $media = $this->get($id);
        return $media->delete();
    }

    public function changePosition(int $id, int $position)
    {
        $media = $this->get($id);
        return $media->update(['ord' => $position]);
    }
}
