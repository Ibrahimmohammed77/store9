<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\Cart\CartRepository;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepository::class;
    }
}
