<?php

namespace Entryshop\Utils\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Any extends Route
{
    public string $method = 'any';
}
