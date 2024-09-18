<?php

use Entryshop\Hook\Facades\Eventy;
use Entryshop\Hook\Facades\Hook;

if (!function_exists('hook_filter')) {
    /**
     * PHP 代码 hook filter 埋点
     *
     * @param $hookKey
     * @param $hookValue
     */
    function hook_filter($hookKey, $hookValue)
    {
        return Eventy::filter($hookKey, $hookValue);
    }
}

if (!function_exists('hook_action')) {
    /**
     * PHP 代码 hook action 埋点
     *
     * @param $hookKey
     * @param $hookValue
     */
    function hook_action($hookKey, $hookValue = null)
    {
        Eventy::action($hookKey, $hookValue);
    }
}

if (!function_exists('add_hook_filter')) {
    /**
     * 添加 Filter, 执行 PHP 逻辑
     *
     * @param $hookKey
     * @param $callback
     * @param  int  $priority
     * @param  int  $arguments
     * @return mixed
     */
    function add_hook_filter($hookKey, $callback, int $priority = 20, int $arguments = 1): mixed
    {
        return Eventy::addFilter($hookKey, $callback, $priority, $arguments);
    }
}

if (!function_exists('add_hook_action')) {
    /**
     * 添加 Action, 执行 PHP 逻辑
     *
     * @param $hookKey
     * @param $callback
     * @param  int  $priority
     * @param  int  $arguments
     */
    function add_hook_action($hookKey, $callback, int $priority = 20, int $arguments = 1)
    {
        Eventy::addAction($hookKey, $callback, $priority, $arguments);
    }
}

if (!function_exists('add_hook_blade')) {
    /**
     * 采用 Hook 修改 Blade 代码
     * add_hook_blade('hook-name', function ($callback, $output, $data) {});
     *
     * @param $hookKey
     * @param $callback
     * @param  int  $priority
     */
    function add_hook_blade($hookKey, $callback, int $priority = 0)
    {
        Hook::listen($hookKey, $callback, $priority);
    }
}
