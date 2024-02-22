<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\Favorite\FavoriteRepository;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FavoriteRepository::class;
    }
}