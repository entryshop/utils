<?php

namespace Entryshop\Utils\Components;

/**
 * @property string $view_namespace
 * @property string $default_type
 * @method string|static type($value = null)
 */
trait HasViewNamespace
{
    public function view($value = null)
    {
        if (empty($value)) {
            return $this->get('view', $this->view_namespace . $this->get('type', $this->default_type));
        }
        return parent::view($value);
    }
}
