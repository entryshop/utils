<?php

namespace Entryshop\Utils\Components;

trait HasVariables
{
    protected $variables = [];
    protected $original_variables = [];
    private $__built = false;

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $_key => $_value) {
                $this->set($_key, $_value);
            }
            return $this;
        }
        $this->variables[$key] = $value;
        return $this;
    }

    public function get($key, $default = null)
    {
        return evaluate($this->variables[$key] ?? $default, $this->renderable ?? $this);
    }

    public function getOriginal($key, $default = null)
    {
        if ($this->__built) {
            return $this->original_variables[$key] ?? $default;
        }

        return $this->variables[$key] ?? $default;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->variables);
    }

    public function push($key, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $this->variables[$key] = array_merge($this->variables[$key] ?? [], $value);
        return $this;
    }

    public function getOrPush($key, $value = null)
    {
        if (empty($value)) {
            $result = $this->get($key, []);
            if (!empty(array_keys($result))) {
                return $result;
            }
            return array_unique($result);
        }

        return $this->push($key, $value);
    }

    public function variables()
    {
        $built_variable = [];
        foreach ($this->variables as $key => $variable) {
            $built_variable[$key] = evaluate($variable, $this->renderable ?? $this);
        }
        return $built_variable;
    }
}
