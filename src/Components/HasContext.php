<?php

namespace Entryshop\Utils\Components;

trait HasContext
{
    protected array $_context = [];

    public function setContext($key, $value = null)
    {
        if (is_array($key)) {
            $this->_context = array_merge($this->_context, $key);
            return $this;
        }
        $this->_context[$key] = $value;
        return $this;
    }

    public function getContext($key = null, $default = null)
    {
        if (empty($key)) {
            return $this->_context;
        }
        return $this->_context[$key] ?? $default;
    }
}
