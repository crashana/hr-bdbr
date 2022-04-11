<?php

return [

    [
        'interface' => App\Repositories\Media\MediaRepoInterface::class,
        'cache' => App\Repositories\Media\MediaRepo::class,
        'direct' => App\Repositories\Media\MediaRepo::class,
    ],


    [
        'interface' => App\Repositories\Candidates\CandidateRepoInterface::class,
        'cache' => App\Repositories\Candidates\CandidateCacheRepo::class,
        'direct' => App\Repositories\Candidates\CandidateRepo::class,
    ],


];
