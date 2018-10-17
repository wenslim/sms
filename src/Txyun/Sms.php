<?php

namespace Wenslim\Sms\Txyun;

use GuzzleHttp\Client;

class Sms
{
    // User console key and secret
    private $appid;
    private $appkey;

    // Signature instance
    protected $signature;

    // params repository
    public $postParams = [];

    /**
     * Init
     *
     * @param string $appid
     * @param string $appkey
     */
    public function __construct(string $appid, string $appkey)
    {
        $this -> appid = $appid;
        $this -> appkey = $appkey;

        $this -> signature = new Signature;
    }

    /**
     * Set nationcode and mobile
     *
     * @param string $nationcode
     * @param string $mobile
     * @return void
     */
    public function setMobile(string $nationcode, string $mobile)
    {
        $this -> postParams["tel"] = [
            "mobile" => $mobile,
            "nationcode" => $nationcode
        ];
    }

    /**
     * Set message template id
     *
     * @param [type] $tplId
     * @return void
     */
    public function setTplId($tplId)
    {
        $this -> postParams["tpl_id"] = $tplId;
    }

    /**
     * Set messsage template param if is exist
     *
     * @param array $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this -> postParams["params"] = $params;
    }

    /**
     * Send message
     *
     * @return array
     * {"result":0,"errmsg":"OK","sid":"2019:-6294028687446211774","fee":1}
     */
    public function send()
    {
        $random = mt_rand(1000000000, 9999999999);
        $time = time();
        $config = [
            'appkey' => $this -> appkey,
            'random' => $random,
            'time' => $time,
            'mobile' => $this -> postParams['tel']['mobile']
        ];
        $sig = $this -> signature -> getSignature($config);

        // Build params
        $this -> postParams['sig'] = $sig;
        $this -> postParams['time'] = $time;

        // Build url
        $url = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid={$this -> appid}&random=$random";

        // Send
        try {
            $client = new Client();
            // Notice.
            // 1. Use json
            // 2. Close ssl verify
            $response = $client -> request('POST', $url, [
                'json' => $this -> postParams,
                'verify' => false
            ]) -> getBody() -> getContents();
            return json_decode($response, true);
        } catch (\Exception $e) {
            throw new \Exception($e -> getMessage(), $e -> getCode(), $e);
        }
    }
}