<?php

namespace Entryshop\Utils\Actions;

use Closure;

trait AsPipeLineAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    protected mixed $passThrough = null;

    public function then(Closure $callback)
    {
        return $callback($this->passThrough);
    }
}
