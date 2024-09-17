<?php

namespace Entryshop\Utils\Support;

use Entryshop\Utils\Facades\BlinkFacade as Blink;
use ReflectionClass;

trait CachesProperties
{
    public static function bootCachesProperties()
    {
        static::retrieved(function ($model) {
            $model->restoreProperties();
        });
    }

    public function refresh()
    {
        parent::refresh();

        $ro = new ReflectionClass($this);

        foreach ($this->cachableProperties as $property) {
            $defaultValue = $ro->getProperty($property)->getDefaultValue();

            $this->{$property} = $defaultValue;
        }

        return $this;
    }

    /**
     * Returns a unique key for the cache.
     *
     * @return string
     */
    protected function cachePropertiesPrefix()
    {
        return get_class($this) . $this->id . '_';
    }

    public function cacheProperties()
    {
        foreach ($this->cachableProperties as $property) {
            Blink::put($this->cachePropertiesPrefix() . $property, $this->{$property});
        }

        return $this;
    }

    /**
     * Restores properties from the same request.
     *
     * @return void
     */
    public function restoreProperties()
    {
        foreach ($this->cachableProperties as $property) {
            if (Blink::has($this->cachePropertiesPrefix() . $property)) {
                $this->{$property} = Blink::get($this->cachePropertiesPrefix() . $property);
            }
        }
    }
}
