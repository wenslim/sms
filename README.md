<h1 align="center">发送短信</h1>

<p align="center">:email: 阿里云与腾讯云短信服务</p>

## 安装
```php
$ composer require wenslim/sms
```

## 阿里云短信
### 配置
> 进入控制台短信服务
1. 点击「AccessKey」获取 `AccessKey ID` 和 `Access Key Secret`
2. 设置短信签名与模版code

### 使用 
```php
use Wenslim\Sms\Aliyun\Sms;

// 基础配置中获取的密钥
$accessKeyId = 'xxxxxxxxx';
$accessKeySecret = 'xxxxxxxxx';

// 初始化 Sms 类
$sms = new Sms($accessKeyId, $accessKeySecret);

// 接受人手机号
$sms -> setPhoneNumbers('xxxxxxxxxxx');

// 短信签名 & 短信模版CODE
$sms -> setSignName('xxx');
$sms -> setTemplateCode('xxx');

// 当模版设置变量
$sms -> setTemplateParam("{'code': '1234'}");
$sms -> send();
```
### 返回示例
```php
array(4) {
    ["Message"] => string(2) "OK"
    ["RequestId"] => string(36) "AE61E75C-6057-493A-989D-53DCF44C3686"
    ["BizId"] => string(20) "357420138207838299^0"
    ["Code"] => string(2) "OK"
}
```

### 参考
- [官方 SDK](https://help.aliyun.com/document_detail/55451.html)

## 腾讯云短信
### 配置
进入控制台短信服务
1. 获取 `appid` 和 `appkey`
2. 配置签名与短信正文模版
### 基础使用
```php
use Wenslim\Sms\Txyun\Sms;

$appid = "xxxxxxxx";
$appkey = "xxxxxxxxxxxxxxxxxxxx";

$sms = new Sms($appid, $appkey);
// 国家码 & 手机号
$sms -> setMobile('86', '158xxxxxxxx');
// 模版 ID
$sms -> setTplId(xxxxxx);
// 模版参数
$sms -> setParams(["1234", "2"]);
$sms -> send();
```
### 返回示例
```php
array:4 [
    "result" => 0
    "errmsg" => "OK"
    "sid" => "2019:-6287508033737713054"
    "fee" => 1
]
```
### 参考
- [官方 SDK](https://cloud.tencent.com/document/product/382)

## 在 Laravel 中使用
`config/services.php`
```php
.
.
.
'sms' => [
    // 阿里云
    'aliyun' => [
        'accessKeyId' => env('SMS_ALIYUN_KEY'),
        'accessKeySecret' => env('SMS_ALIYUN_SECRET'),
    ],
    // 腾讯云
    'txyun' => [
        'appid' => env('SMS_TXYUN_APPID'),
        'appkey' => env('SMS_TXYUN_APPKEY'),
    ]
],
```
`.env`
```php
.
.
.
// 阿里云
SMS_ALIYUN_KEY=xxxxxx
SMS_ALIYUN_SECRET=xxxxxx
// 腾讯云
SMS_TXYUN_APPID=xxxxxx
SMS_TXYUN_APPKEY=xxxxxx
```
eg. `UserController.php`

### 阿里云
使用方法注入
```php
use Wenslim\Sms\Aliyun\Sms;

class UserController extends Controller
{
    public function send(Sms $sms)
    {
        $sms -> setPhoneNumbers('xxxxxx');
    	$sms -> setSignName('xxxxxx');
        $sms -> setTemplateCode('xxxxxx');
        $sms -> setTemplateParam("{'code': '1234'}");
        $response = $sms -> send();
    }
}
```
使用服务名称
```php
class UserController extends Controller
{
    public function send()
    {
        $sms = app('sms');
        $sms -> setSignName('xxxxxx');
        $sms -> setTemplateCode('xxxxxx');
        $sms -> setTemplateParam("{'code': '1234'}");
        $response = $sms -> send();
    }
}
```
### 腾讯云
使用方法注入
```php
use Wenslim\Sms\Txyun\Sms;

class UserController extends Controller
{
    public function send(Sms $sms)
    {
        $sms -> setMobile('86', '158xxxxxxxx');
        $sms -> setTplId(xxxxxx);
        $sms -> setParams(["1234", "3"]);
        $response = $sms -> send();
    }
}
```
使用服务名称
```php
class UserController extends Controller
{
    public function send()
    {
        $sms = app("tx_sms");
        $sms -> setMobile('86', '158xxxxxxxx');
        $sms -> setTplId(xxxxxx);
        $sms -> setParams(["1234", "2"]);
        $result = $sms -> send();
    }
}
```

## License
MIT