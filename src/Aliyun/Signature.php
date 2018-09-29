<?php

namespace Wenslim\Sms\Aliyun;

use Wenslim\Sms\Aliyun\Params\System;
use Wenslim\Sms\Aliyun\Params\Business;

class Signature
{
    // Request type
    protected $httpMethod = 'POST';
    public $params = [];

    /**
     * Get sign
     *
     * @param [array] $config
     * @param [array] $systemParams
     * @param [array] $businessParams
     * @return string
     */
    public function getSignature($config, $systemParams, $businessParams)
    {
        $accessKeyId = $config['accessKeyId'];
        $accessKeySecret = $config['accessKeySecret'];

        // Merge params
        $params = array_merge([
            'AccessKeyId' => $accessKeyId
        ], $systemParams, $businessParams);
        
        // Store system & business params
        $this -> params = $params;

        // Generate signature
        $signature = $this -> generateSign($params, $accessKeySecret);

        return $signature;
    }

    /**
     * Make signature
     * 
     * 1). Sort the params and recompose like
     * key + "=" + value
     * 
     * 2). + replace to %20、* replace to %2A、%7E replace to ~
     * @return string
     */
    public function generateSign(array $params, $accessKeySecret)
    {
        ksort($params);
        $arr = [];

        foreach ($params as $k => $v) {
            array_push($arr, $this -> percentEncode($k) . '=' . $this -> percentEncode($v));
        }

        $queryStr = implode('&', $arr);
        $strToSign = $this -> httpMethod . '&%2F&' . $this -> percentEncode($queryStr);
        
        return base64_encode(hash_hmac('sha1', $strToSign, $accessKeySecret . '&', true));
    }

    /**
     * Handle replacement
     *
     * @param string $str
     * @return string
     */
    private function percentEncode(string $str)
    {
        $res = urlencode($str);
	    $res = preg_replace('/\+/', '%20', $res);
	    $res = preg_replace('/\*/', '%2A', $res);
	    $res = preg_replace('/%7E/', '~', $res);
	    return $res;
    }
}