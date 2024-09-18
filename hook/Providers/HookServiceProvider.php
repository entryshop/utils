<?php

namespace Entryshop\Hook\Providers;

use Entryshop\Hook\Console\HookListeners;
use Entryshop\Hook\Hook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            HookListeners::class,
        ]);

        $this->app->singleton(Hook::class);

        $this->app->register(EventBladeServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }


    public function boot()
    {
        $this->bootHookDirectives();
        $this->bootWrapperHookDirectives();
    }

    /**
     * 添加 blade hook 标签, 不需要 @endhook
     * @hook('xxx'), 添加 hook 直接输出到页面
     */
    protected function bootHookDirectives()
    {
        Blade::directive('hook', function ($parameter) {
            $parameter  = trim($parameter, '()');
            $parameters = explode(',', $parameter);
            $name       = trim($parameters[0], "'");

            return ' <?php
                $__definedVars = (get_defined_vars()["__data"]);
                if (empty($__definedVars))
                {
                    $__definedVars = [];
                }
                $output = \Entryshop\Hook\Facades\Hook::getHook("' . $name . '",["data"=>$__definedVars],function($data) { return null; });
                if ($output)
                echo $output;
                ?>';
        });
    }


    /**
     * 添加 blade wrapper hook 标签
     *
     * @hookwrapper('xxx') --- @endhookwrapper, 将某段代码打包输出再添加 hook 输出
     */
    protected function bootWrapperHookDirectives()
    {
        Blade::directive('hookwrapper', function ($parameter) {
            $parameter  = trim($parameter, '()');
            $parameters = explode(',', $parameter);
            $name       = trim($parameters[0], "'");

            return ' <?php
                    $__hook_name="' . $name . '";
                    ob_start();
                ?>';
        });

        Blade::directive('endhookwrapper', function () {
            return ' <?php
                $__definedVars = (get_defined_vars()["__data"]);
                if (empty($__definedVars))
                {
                    $__definedVars = [];
                }
                $__hook_content = ob_get_clean();
                $output = \Entryshop\Hook\Facades\Hook::getWrapper("$__hook_name",["data"=>$__definedVars],function($data) { return null; },$__hook_content);
                unset($__hook_name);
                unset($__hook_content);
                if ($output)
                echo $output;
                ?>';
        });
    }
}
