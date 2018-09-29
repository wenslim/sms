<h1 align="center">发送短信</h1>

<p align="center">:email: 基于阿里云短信服务云通信.</p>

## 安装
```php
$ composer require wenslim/sms
```

## 基础配置
- 进入「[阿里云控制台](https://home.console.aliyun.com)」
- 搜索「短信服务」
- 点击「AccessKey」获取 `AccessKey ID` 和 `Access Key Secret`

## 短信配置
1. 短信签名
> 短信服务 -> 国内消息 -> 签名管理 -> 添加签名 -> 签名名称
2. 模版 code
> 短信服务 -> 国内消息 -> 模版管理 -> 添加模版 -> 模版CODE

## 使用
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
返回示例：
```php
array(4) {
    ["Message"] => string(2) "OK"
    ["RequestId"] => string(36) "AE61E75C-6057-493A-989D-53DCF44C3686"
    ["BizId"] => string(20) "357420138207838299^0"
    ["Code"] => string(2) "OK"
}
```

## 参考
- [官方 SDK](https://help.aliyun.com/document_detail/55451.html)

## License
MIT