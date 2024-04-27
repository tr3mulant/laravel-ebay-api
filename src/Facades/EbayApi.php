<?php

namespace TremulantTech\LaravelEbayApi\Facades;

use Illuminate\Support\Facades\Facade;

class EbayApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'EbayApi';
    }
}
