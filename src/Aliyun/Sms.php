<?php

namespace Wenslim\Sms\Aliyun;

use Wenslim\Sms\Aliyun\Params\System;
use Wenslim\Sms\Aliyun\Params\Business;
use GuzzleHttp\Client;

class Sms
{
    // User console key and secret
    private $accessKeyId;
    private $accessKeySecret;

    // System instance
    protected $system;
    // Business instance
    protected $business;
    // sign
    protected $signature;

    // api
    protected $domain = "http://dysmsapi.aliyuncs.com/";

    /**
     * Init instance & key secret
     */
    public function __construct(string $accessKeyId, string $accessKeySecret)
    {
        $this -> system = new System;
        $this -> business = new Business;
        $this -> signature = new Signature;

        $this -> accessKeyId = $accessKeyId;
        $this -> accessKeySecret = $accessKeySecret;
    }

    /**
     * Set accept user phone number
     *
     * @param [string] $phoneNumber
     * @return void
     */
    public function setPhoneNumbers($phoneNumber)
    {
        $this -> business -> setPhoneNumbers($phoneNumber);
    }

    /**
     * Set short message sign
     *
     * @param [string] $signName
     * @return void
     */
    public function setSignName($signName)
    {
        $this -> business -> setSignName($signName);
    }

    /**
     * Set short message template id
     * 
     * @return void
     */
    public function setTemplateCode($templateCode)
    {
        $this -> business -> setTemplateCode($templateCode);
    }

    /**
     * Set template variable - optional
     *
     * @example {'code': '1234', 'product': 'ytx'}
     * @param [string] $templateParam
     * @return void
     */
    public function setTemplateParam($templateParam)
    {
        $this -> business -> setTemplateParam($templateParam);
    }

    /**
     * Set return type - [default] JSON
     *
     * @param [type] $format
     * @return void
     */
    public function setFormat($format)
    {
        $this -> system -> setFormat($format);
    }

    /**
     * Get sign
     *
     * @return void
     */
    public function getSignature()
    {
        $config = [
            'accessKeyId' => $this -> accessKeyId,
            'accessKeySecret' => $this -> accessKeySecret
        ];
        $systemParams = $this -> system -> getSystemParams();
        $businessParams = $this -> business -> getBusinessParams();
        
        return $this -> signature -> getSignature($config, $systemParams, $businessParams);
    }

    /**
     * Send short message
     *
     * @return array
     * string(110) "{"Message":"OK","RequestId":"1E6BE375-211A-4020-B680-D1D0433C9202",
     * "BizId":"224903638193871636^0","Code":"OK"}"
     */
    public function send()
    {
        $signature = $this -> getSignature();
        $params = $this -> signature -> params;
        $params['Signature'] = $signature;

        try {
            $client = new Client();
            $response = $client -> post($this -> domain, [
                'query' => $params
            ]) -> getBody() -> getContents();

            return json_decode($response, true);
        } catch (\Exception $e) {
            throw new \Exception($e -> getMessage(), $e -> getCode(), $e);
        }
    }
}