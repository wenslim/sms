<?php

namespace Wenslim\Sms\Aliyun\Params;

class Business
{
    /**
     * Fixed value
     */
    protected $action = 'SendSms';
    protected $version = '2017-05-25';
    protected $regionId = 'cn-hangzhou';

    /**
     * User optional
     */
    protected $phoneNumbers;
    protected $signName;
    protected $templateCode;
    protected $templateParam;

    public function setPhoneNumbers($phoneNumbers)
    {
        $this -> phoneNumbers = $phoneNumbers;
    }

    public function setSignName($signName)
    {
        $this -> signName = $signName;
    }

    public function setTemplateCode($templateCode)
    {
        $this -> templateCode = $templateCode;
    }

    public function setTemplateParam($templateParam)
    {
        $this -> templateParam = $templateParam;
    }

    /**
     * Get business params
     *
     * @return array
     */
    public function getBusinessParams()
    {
        $arr = [
            'Action' => $this -> action,
            'Version' => $this -> version,
            'RegionId' => $this -> regionId,
            'PhoneNumbers' => $this -> phoneNumbers,
            'SignName' => $this -> signName,
            'TemplateCode' => $this -> templateCode
        ];

        // If or not made variable in template
        if (isset($this -> templateParam) && !empty($this -> templateParam)) {
            $arr['TemplateParam'] = $this -> templateParam;
        }

        return $arr;
    }
}