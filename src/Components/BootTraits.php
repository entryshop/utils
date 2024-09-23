<?php

namespace Entryshop\Utils\Components;

trait BootTraits
{
    private $_booted = false;
    private $_registered = false;

    public function boot()
    {
        if ($this->_booted) {
            return;
        }

        $self = static::class;

        foreach (class_uses_recursive($self) as $trait) {
            if (method_exists($self, $method = 'boot' . class_basename($trait))) {
                $this->$method();
            }
        }

        $this->_booted = true;
    }

    public function register(...$args)
    {
        if ($this->_registered) {
            return;
        }
        $self = static::class;
        foreach (class_uses_recursive($self) as $trait) {
            if (method_exists($self, $method = 'register' . class_basename($trait))) {
                $this->$method(...$args);
            }
        }
        $this->_registered = true;
    }
}
