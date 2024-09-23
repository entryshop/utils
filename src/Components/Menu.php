<?php

namespace Entryshop\Utils\Components;

/**
 * @method string|static url($value = null)
 * @method string|static icon($value = null)
 * @method string|static order($value = null)
 */
class Menu extends Renderable
{
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        if (!empty($args[0]['children'])) {
            $children = $args[0]['children'];
            foreach ($children as $child) {
                $this->child($child);
            }
        }
    }
}
