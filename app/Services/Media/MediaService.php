<?php

namespace App\Services\Media;

use App\Repositories\Media\MediaRepo;
use App\Repositories\Media\MediaRepoInterface;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Support\Facades\File;

class MediaService extends MainService
{
    protected $mediaRepo;

    public function __construct(
        MediaRepoInterface $mediaRepo
    ) {
        $this->mediaRepo = $mediaRepo;
    }


    public function uploadFile(
        Model $attachTo,
        object $fileInput,
        string $collectionName = null,
        string $storePath = null
    ) {
        $savedFileInfo = $this->saveFile($fileInput, $storePath);
        return $this->saveInDB(
            $attachTo,
            $savedFileInfo,
            $collectionName
        );
    }

    public function delete(int $id)
    {
        $media = $this->mediaRepo->get($id);
        $filePath = public_path($media->path . '/' . $media->file_name);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        return $this->mediaRepo->delete($media->id);
    }


    protected function saveInDB(
        Model $attachTo = null,
        object $fileInfo,
        string $collectionName = null,
        int $order = 0
    ) {

        $data = new ParameterBag([
            'collection_name' => $collectionName,
            'path' => $fileInfo->pathToFile,
            'name' => $fileInfo->fileInfo->nativeName,
            'file_name' => $fileInfo->fileName,
            'mime_type' => $fileInfo->fileInfo->mimeType,
            'extension' => $fileInfo->fileInfo->extension,
            'ord' => $order,
        ]);
        $media = $this->mediaRepo->create($data);

        $attachTo->media()->save($media);
        return true;
    }


    protected function fileInfo($fileInput)
    {
        if (gettype($fileInput) == 'string') {
            $nativeName = preg_replace(
                '/\\.[^.\\s]{3,4}$/',
                '',
                File::name($fileInput)
            );
            $originalName = File::name($fileInput);
            $extension = File::extension($fileInput);
            $mimeType = File::mimeType($fileInput);
        } else {
            $nativeName = preg_replace(
                '/\\.[^.\\s]{3,4}$/',
                '',
                $fileInput->getClientOriginalName()
            );
            $originalName = $fileInput->getClientOriginalName();
            $extension = $fileInput->getClientOriginalExtension();
            $mimeType = $fileInput->getMimeType();
        }

        $storeName = str_replace(' ', '_', $nativeName)
            . rand()
            . date('h_i_s');
        $updateName = str_replace(' ', '_', $nativeName);
        return (object)[
            'storeName' => $storeName,
            'nativeName' => $nativeName,
            'updateName' => $updateName,
            'originalName' => $originalName,
            'extension' => $extension,
            'mimeType' => $mimeType
        ];
    }


    protected function path(string $storePath = null)
    {
        $path = base_path('public/storage');
        $storePath ? $path = $path . '/' . $storePath . '/' . date('Y-m') : $path = $path . '/' . date('y-m');
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0775, true, true);
        }
        return $path;
    }

    protected function saveFile(object $fileInput, string $storePath = null)
    {
        $path = $this->path($storePath);
        $fileInfo = $this->fileInfo($fileInput);
        $fileName = $fileInfo->storeName . '.' . $fileInfo->extension;
        $fileInput->move($path, $fileName);
        return (object)[
            'fileName' => $fileName,
            'path' => $path,
            'pathToFile' => str_replace(public_path(), '', $path),
            'fileInfo' => $fileInfo,
        ];
    }


    public function changePosition(int $id, int $position)
    {
        return $this->mediaRepo->changePosition($id, $position);
    }
}
