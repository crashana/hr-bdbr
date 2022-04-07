<?php

return [

    [
        'interface' => App\Repositories\Admins\AdminRepoInterface::class,
        'cache' => App\Repositories\Admins\AdminCacheRepo::class,
        'direct' => App\Repositories\Admins\AdminRepo::class,
    ],

    [
        'interface' => App\Repositories\Admins\Roles\RoleRepoInterface::class,
        'cache' => App\Repositories\Admins\Roles\RoleRepo::class,
        'direct' => App\Repositories\Admins\Roles\RoleRepo::class
    ],

    [
        'interface' => App\Repositories\Locales\LocalesRepoInterface::class,
        'cache' => App\Repositories\Locales\LocalesCacheRepo::class,
        'direct' => App\Repositories\Locales\LocalesRepo::class
    ],


    [
        'interface' => App\Repositories\Media\MediaRepoInterface::class,
        'cache' => App\Repositories\Media\MediaRepo::class,
        'direct' => App\Repositories\Media\MediaRepo::class
    ],

];
