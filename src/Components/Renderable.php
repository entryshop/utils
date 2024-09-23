<?php

namespace Entryshop\Utils\Components;

use Entryshop\Utils\Support\CanCallMethods;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

/**
 * @method string|static view($value = null) Get/set view file
 * @method string|static display($value = null) Get/set display content
 */
class Renderable
{
    use BootTraits;
    use CanCallMethods;
    use HasAttributes;
    use HasChildren;
    use HasContext;
    use HasVariables;
    use Makable;
    use Macroable {
        __callStatic as macroCallStatic;
        __call as macroCall;
    }

    protected $default_view;

    public function __construct(...$args)
    {
        $this->register(...$args);

        if (!empty($args[0]) && is_array($args[0])) {
            foreach ($args[0] as $key => $value) {
                $this->set($key, $value);
            }
        }

        if (empty($this->key())) {
            $this->key($this->name() ?? Str::slug(class_basename(static::class)) . '_' . uniqid());
        }
    }

    public function render(...$args)
    {
        if (!empty($args[0]) && is_array($args[0])) {
            $this->setContext($args[0]);
        }

        $this->__callMethods('build', '', ...$args);

        $this->boot();

        if ($this->has('display')) {
            return $this->get('display');
        }

        $_view = $this->getView(...$args);

        if (!view()->exists($_view)) {
            return '';
        }

        $data = $this->getViewData(...$args);

        if ($data['hide'] ?? false) {
            return '';
        }
        return view($_view, $this->getViewData(...$args));
    }

    public function __call($method, $parameters)
    {
        // call marco
        if ($this->hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        if (count($parameters) === 1) {
            return $this->set($method, $parameters[0]);
        }

        if (count($parameters) === 0) {
            return $this->get($method);
        }

        return $this;
    }

    public function getView(...$args)
    {
        return $this->view() ?? $this->default_view;
    }

    public function getViewData(...$args)
    {
        $data = array_merge($this->getContext(), [
            'renderable' => $this,
        ]);

        return array_merge($data, $this->variables());
    }
}
