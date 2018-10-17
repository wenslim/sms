<?php

namespace Wenslim\Sms\Txyun;

class Signature
{
    /**
     * get signature
     *
     * @param array $config
     * @return string
     */
    public function getSignature(array $config)
    {
        if (count($config) > 0) {
            $strSig = "appkey={$config['appkey']}&random={$config['random']}&time={$config['time']}&mobile={$config['mobile']}";
        }

        return hash('sha256', $strSig);
    }
}