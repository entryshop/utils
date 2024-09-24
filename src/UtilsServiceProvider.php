<?php

namespace Entryshop\Utils;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider
{
    public function register()
    {
        require_once __DIR__ . '/macros.php';
    }

    public function boot()
    {
    }

}
