<?php

namespace Entryshop\Utils\Support;

use Entryshop\Utils\Actions\AsAction;
use Illuminate\Support\Str;

class GuessLanguage
{
    use AsAction;

    public function handle()
    {
        $lang_map = [
            'en_us' => 'en',
            'en-us' => 'en',
            'zh'    => 'zh_CN',
            'zh-cn' => 'zh_CN',
            'zh_cn' => 'zh_CN',
            'zh-tw' => 'zh_TW',
            'zh_tw' => 'zh_TW',
            'tw'    => 'zh_TW',
            'vi_VN' => 'vi',
            'vi-VN' => 'vi',
            'vi'    => 'vi',
            'vn'    => 'vi',
        ];

        if (request()->has('lang')) {
            $lang = request()->input('lang');
        } elseif (session()->has("lang_code")) {
            $lang = session()->get("lang_code");
        } elseif (auth()->user()?->language) {
            $lang = Str::lower(auth()->user()->language);
        } elseif (request()->getLanguages()) {
            $lang = request()->getLanguages()[0];
        } else {
            return config('app.locale');
        }

        return $lang_map[Str::lower($lang)] ?? $lang;
    }
}
