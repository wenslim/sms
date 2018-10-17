<?php

namespace Wenslim\Sms\Txyun;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this -> app -> singleton(Sms::class, function(){
            return new Sms(
                config('services.sms.txyun.appid'), 
                config('services.sms.txyun.appkey')
            );
        });

        $this -> app -> alias(Sms::class, 'tx_sms');
    }

    public function provides()
    {
        return [Sms::class, 'tx_sms'];
    }
}