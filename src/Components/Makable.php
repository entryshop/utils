<?php

namespace Entryshop\Utils\Components;

use Closure;

trait Makable
{
    public static function make(...$args)
    {
        if (!empty($args[0]) && $args[0] instanceof Closure) {
            $instance = new static();
            call_user_func($args[0], $instance);
            return $instance;
        }
        return new static(...$args);
    }
}
