<?php

namespace Entryshop\Utils\Facades;

use Entryshop\Utils\Support\Blink;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin Blink
 */
class BlinkFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Blink::class;
    }
}
