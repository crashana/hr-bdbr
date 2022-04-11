<?php

namespace App\Repositories\Media;

use App\Models\Media\Media;
use App\Models\Media\MediaResponsive;
use Symfony\Component\HttpFoundation\ParameterBag;

interface MediaRepoInterface
{

    public function get(int $id): Media;

    public function create(ParameterBag $data): Media;

    public function delete(int $id): bool;

    public function changePosition(int $id, int $position);
}
