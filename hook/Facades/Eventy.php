<?php

namespace Entryshop\Hook\Facades;

use Illuminate\Support\Facades\Facade;

class Eventy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eventy';
    }
}
