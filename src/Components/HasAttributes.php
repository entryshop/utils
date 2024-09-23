<?php

namespace Entryshop\Utils\Components;

use Closure;

trait HasAttributes
{
    protected $_classes = [];
    protected $_attributes = [];

    public function class($value)
    {
        if (is_string($value)) {
            $value = explode(' ', $value);
        }
        $this->_classes = array_merge($this->_classes, $value);

        return $this;
    }

    public function attr($key, $value)
    {
        $this->_attributes[$key] = $value;
        return $this;
    }

    public function wrapper($value = null)
    {
        if (!empty($value)) {
            return $this->set('wrapper', $value);
        }

        $this->bootHasAttributes();
        return $this->get('wrapper');
    }

    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function bootHasAttributes()
    {
        if ($this->has('wrapper')) {
            return;
        }

        $wrapper = '';
        $classes = [];
        foreach ($this->_classes as $class) {
            if ($class instanceof Closure) {
                $class = evaluate($class, $this->renderable ?? $this);
            }
            $classes[] = $class;
        }

        if (!empty($classes)) {
            $class_string = implode(' ', $classes);
            $wrapper      .= 'class="' . $class_string . '" ';
        }

        foreach ($this->_attributes as $key => $value) {
            if ($value instanceof Closure) {
                $value = evaluate($value, $this->renderable ?? $this);
            }
            $wrapper .= $key . '="' . $value . '" ';
        }

        if (!empty($wrapper)) {
            $this->set('wrapper', $wrapper);
        }
    }
}
