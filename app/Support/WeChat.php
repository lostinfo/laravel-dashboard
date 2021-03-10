<?php

namespace App\Support;


use EasyWeChat\Factory;

class WeChat
{
    /**
     * @return \EasyWeChat\MiniProgram\Application
     */
    public static function getMiniProgramApp()
    {
        $app = Factory::miniProgram([
            'app_id' => config("wechat.app_id"),
            'secret' => config("wechat.secret"),

            'response_type' => 'array',
            'log'           => [
                'level' => 'debug',
                'file'  => storage_path('logs/wechat-' . date('Y-m-d') . '.log'),
            ],
        ]);
        $app->rebind('cache', app('cache.store'));
        return $app;
    }

    /**
     * @return \EasyWeChat\Payment\Application
     */
    public static function getPayApp()
    {
        $app = Factory::payment([
            'app_id'     => config("wechat.app_id"),
            'mch_id'     => config("wechat.mch_id"),
            'key'        => config("wechat.key"),
            'cert_path'  => config("wechat.cert_path"),
            'key_path'   => config("wechat.key_path"),
            'notify_url' => config("wechat.notify_url"),
            'log'        => [
                'level' => 'debug',
                'file'  => storage_path('logs/wechat-pay-' . date('Y-m-d') . '.log'),
            ],
        ]);
        $app->rebind('cache', app('cache.store'));
        return $app;
    }
}
