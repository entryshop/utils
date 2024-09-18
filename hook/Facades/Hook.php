<?php

namespace Entryshop\Hook\Facades;

use Illuminate\Support\Facades\Facade;

class Hook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Entryshop\Hook\Hook::class;
    }
}
