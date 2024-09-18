<?php

namespace Entryshop\Hook\Providers;

use Illuminate\Support\ServiceProvider;
use Entryshop\Hook\Events;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('eventy', function ($app) {
            return new Events();
        });
    }
}
