<?php

namespace Wenslim\Sms\Aliyun;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this -> app -> singleton(Sms::class, function(){
            return new Sms(
                config('services.sms.aliyun.accessKeyId'), 
                config('services.sms.aliyun.accessKeySecret')
            );
        });

        $this -> app -> alias(Sms::class, 'sms');
    }

    public function provides()
    {
        return [Sms::class, 'sms'];
    }
}