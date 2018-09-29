<?php

namespace Wenslim\Sms\Aliyun\Params;

class System
{
    /**
     * Fixed value
     */
    protected $signatureMethod = 'HMAC-SHA1';
    protected $SignatureVersion = '1.0';

    // User optional
    protected $format = 'JSON';

    public function setFormat($format)
    {
        $this -> format = $format;
    }

    /**
     * Date format
     * 
     * Format：「Y-m-d\TH:i:s\Z」 Timezone：「GMT」
     * @return void
     */
    public function getTimestamp()
    {
        // Default timezone
        $timezone = date_default_timezone_get();
        // Set timezone
        date_default_timezone_set('GMT');
        $timestamp = date('Y-m-d\TH:i:s\Z');
        // Recover default timezone
        date_default_timezone_set($timezone);

        return $timestamp;
    }

    /**
     * Get system params
     *
     * @return array
     */
    public function getSystemParams()
    {
        return [
            'Timestamp'        => $this -> getTimestamp(),
            'Format'           => $this -> format,
            'SignatureMethod'  => $this -> signatureMethod,
            'SignatureVersion' => $this -> SignatureVersion,
            'SignatureNonce'   => uniqid(),
        ];
    }
}