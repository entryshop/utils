<?php

/**
 * return implementation class
 */
if (!function_exists('resolve_class')) {
    function resolve_class($contact_class)
    {
        return get_class(resolve($contact_class));
    }
}
