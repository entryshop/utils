<?php

namespace Entryshop\Utils\Components;

/**
 * @mixin HasVariables
 * @property string $asset_prefix
 */
trait HasAssets
{
    public $_assets = [
        'css'     => [],
        'js'      => [],
        'scripts' => [],
        'styles'  => [],
    ];

    public function asset($path, $secure = null)
    {
        return url(($this->asset_prefix ?? '') . $path, $secure);
    }

    public function css($value = null)
    {
        if (empty($value)) {
            return $this->_assets['css'];
        }
        return $this->_assets['css'][] = $value;
    }

    public function js($value = null)
    {
        return $this->getOrPush('js', $value);
    }

    public function scripts($value = null)
    {
        return $this->getOrPush('scripts', $value);
    }

    public function styles($value = null)
    {
        return $this->getOrPush('styles', $value);
    }

    public function cssVar(...$args)
    {
        if (count($args) === 2) {
            $value = [$args[0] => $args[1]];
        } else {
            $value = $args[0] ?? null;
        }
        return $this->getOrPush('cssVar', $value);
    }

}
