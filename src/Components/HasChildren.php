<?php

namespace Entryshop\Utils\Components;

trait HasChildren
{
    protected $_children = [];

    protected $default_child = Renderable::class;

    public function children($position = null)
    {
        if (is_array($position)) {
            foreach ($position as $item) {
                $this->child($item);
            }
            return $this;
        }

        if (empty($position)) {
            $_children = array_filter($this->_children, function ($child) use ($position) {
                return empty($child->get('position'));
            });
        } else {
            $_children = array_filter($this->_children, function ($child) use ($position) {
                return $child->get('position') === $position;
            });
        }


        usort($_children, function ($a, $b) {
            return $a->get('order') <=> $b->get('order');
        });

        return $_children;
    }

    public function child(...$args)
    {
        if (empty($args[0])) {
            abort(400, 'Unknown child type');
        }

        if ($args[0] instanceof Renderable) {
            $child = $args[0];
        } elseif (is_array($args[0])) {
            $child = $this->default_child::make($args[0]);
        } elseif (is_string($args[0])) {
            $child = $this->default_child::make(['name' => $args[0]]);
        } else {
            $child = $this->default_child::make(...$args);
        }

        $key = $child->key() ?? $child->name();

        if (!empty($this->_children[$key])) {
            return $this->_children[$key];
        }

        $this->_children[$key] = $child;
        return $child;
    }
}
