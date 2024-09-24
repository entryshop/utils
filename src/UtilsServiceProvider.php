<?php

namespace Entryshop\Utils;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider
{
    public function register()
    {
        require_once './macros.php';
    }

    public function boot()
    {
    }

}
