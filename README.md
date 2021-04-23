<h1 align="center">yii-pay</h1>

> 基于 [yansongda/pay](https://github.com/yansongda/pay) 开发的适配于 Yii 的 alipay 和 wechat 的支付扩展包。

<p align="center"><img src="./docs/usage.png"></p>

[![Build Status](https://travis-ci.org/guanguans/yii-pay.svg?branch=master)](https://travis-ci.org/guanguans/yii-pay)
[![Build Status](https://scrutinizer-ci.com/g/guanguans/yii-pay/badges/build.png?b=master)](https://scrutinizer-ci.com/g/guanguans/yii-pay/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/guanguans/yii-pay/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/guanguans/yii-pay/?branch=master)
[![codecov](https://codecov.io/gh/guanguans/yii-pay/branch/master/graph/badge.svg)](https://codecov.io/gh/guanguans/yii-pay)
[![StyleCI](https://github.styleci.io/repos/247638891/shield?branch=master)](https://github.styleci.io/repos/247638891)
[![Total Downloads](https://poser.pugx.org/guanguans/yii-pay/downloads)](https://packagist.org/packages/guanguans/yii-pay)
[![Latest Stable Version](https://poser.pugx.org/guanguans/yii-pay/v/stable)](https://packagist.org/packages/guanguans/yii-pay)
[![License](https://poser.pugx.org/guanguans/yii-pay/license)](https://packagist.org/packages/guanguans/yii-pay)

## 环境要求

* Yii >= 2.0

## 安装

``` shell
$ composer require guanguans/yii-pay --prefer-dist -v
```

## 配置

Yii2 配置文件 `config/main.php` 的 components 中添加:

``` php
'components' => [
	// ...
	'pay' => [
        'class' => 'Guanguans\YiiPay\Pay',
        'wechatOptions' => [
            'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
            'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
            'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
            'mch_id' => '14577xxxx',
            'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
            'notify_url' => 'http://xxxxxx.cn/notify.php',
            'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
            'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
            'log' => [ // optional
                'file' => './logs/wechat.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            // 'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
        ],
        'alipayOptions' => [
            'app_id' => '2016082000295641',
            'notify_url' => 'http://xxxxxx.cn/notify.php',
            'return_url' => 'http://xxxxxx.cn/return.php',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuWJKrQ6SWvS6niI+4vEVZiYfjkCfLQfoFI2nCp9ZLDS42QtiL4Ccyx8scgc3nhVwmVRte8f57TFvGhvJD0upT4O5O/lRxmTjechXAorirVdAODpOu0mFfQV9y/T9o9hHnU+VmO5spoVb3umqpq6D/Pt8p25Yk852/w01VTIczrXC4QlrbOEe3sr1E9auoC7rgYjjCO6lZUIDjX/oBmNXZxhRDrYx4Yf5X7y8FRBFvygIE2FgxV4Yw+SL3QAa2m5MLcbusJpxOml9YVQfP8iSurx41PvvXUMo49JG3BDVernaCYXQCoUJv9fJwbnfZd7J5YByC+5KM4sblJTq7bXZWQIDAQAB',
            // 加密方式： **RSA2**  
            'private_key' => 'MIIEpAIBAAKCAQEAs6+F2leOgOrvj9jTeDhb5q46GewOjqLBlGSs/bVL4Z3fMr3p+Q1Tux/6uogeVi/eHd84xvQdfpZ87A1SfoWnEGH5z15yorccxSOwWUI+q8gz51IWqjgZxhWKe31BxNZ+prnQpyeMBtE25fXp5nQZ/pftgePyUUvUZRcAUisswntobDQKbwx28VCXw5XB2A+lvYEvxmMv/QexYjwKK4M54j435TuC3UctZbnuynSPpOmCu45ZhEYXd4YMsGMdZE5/077ZU1aU7wx/gk07PiHImEOCDkzqsFo0Buc/knGcdOiUDvm2hn2y1XvwjyFOThsqCsQYi4JmwZdRa8kvOf57nwIDAQABAoIBAQCw5QCqln4VTrTvcW+msB1ReX57nJgsNfDLbV2dG8mLYQemBa9833DqDK6iynTLNq69y88ylose33o2TVtEccGp8Dqluv6yUAED14G6LexS43KtrXPgugAtsXE253ZDGUNwUggnN1i0MW2RcMqHdQ9ORDWvJUCeZj/AEafgPN8AyiLrZeL07jJz/uaRfAuNqkImCVIarKUX3HBCjl9TpuoMjcMhz/MsOmQ0agtCatO1eoH1sqv5Odvxb1i59c8Hvq/mGEXyRuoiDo05SE6IyXYXr84/Nf2xvVNHNQA6kTckj8shSi+HGM4mO1Y4Pbb7XcnxNkT0Inn6oJMSiy56P+CpAoGBAO1O+5FE1ZuVGuLb48cY+0lHCD+nhSBd66B5FrxgPYCkFOQWR7pWyfNDBlmO3SSooQ8TQXA25blrkDxzOAEGX57EPiipXr/hy5e+WNoukpy09rsO1TMsvC+v0FXLvZ+TIAkqfnYBgaT56ku7yZ8aFGMwdCPL7WJYAwUIcZX8wZ3dAoGBAMHWplAqhe4bfkGOEEpfs6VvEQxCqYMYVyR65K0rI1LiDZn6Ij8fdVtwMjGKFSZZTspmsqnbbuCE/VTyDzF4NpAxdm3cBtZACv1Lpu2Om+aTzhK2PI6WTDVTKAJBYegXaahBCqVbSxieR62IWtmOMjggTtAKWZ1P5LQcRwdkaB2rAoGAWnAPT318Kp7YcDx8whOzMGnxqtCc24jvk2iSUZgb2Dqv+3zCOTF6JUsV0Guxu5bISoZ8GdfSFKf5gBAo97sGFeuUBMsHYPkcLehM1FmLZk1Q+ljcx3P1A/ds3kWXLolTXCrlpvNMBSN5NwOKAyhdPK/qkvnUrfX8sJ5XK2H4J8ECgYAGIZ0HIiE0Y+g9eJnpUFelXvsCEUW9YNK4065SD/BBGedmPHRC3OLgbo8X5A9BNEf6vP7fwpIiRfKhcjqqzOuk6fueA/yvYD04v+Da2MzzoS8+hkcqF3T3pta4I4tORRdRfCUzD80zTSZlRc/h286Y2eTETd+By1onnFFe2X01mwKBgQDaxo4PBcLL2OyVT5DoXiIdTCJ8KNZL9+kV1aiBuOWxnRgkDjPngslzNa1bK+klGgJNYDbQqohKNn1HeFX3mYNfCUpuSnD2Yag53Dd/1DLO+NxzwvTu4D6DCUnMMMBVaF42ig31Bs0jI3JQZVqeeFzSET8fkoFopJf3G6UXlrIEAQ==',
            // 使用公钥证书模式，请配置下面两个参数，同时修改ali_public_key为以.crt结尾的支付宝公钥证书路径，如（./cert/alipayCertPublicKey_RSA2.crt）
            // 'app_cert_public_key' => './cert/appCertPublicKey.crt', //应用公钥证书路径
            // 'alipay_root_cert' => './cert/alipayRootCert.crt', //支付宝根证书路径
            'log' => [ // optional
                'file' => './logs/alipay.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ],
    ],
	// ...
]
```

## 使用

### 获取 alipay 实例

``` php
Yii::$app->pay->getAlipay();
// or
Yii::$app->pay->alipay;
```

### 支付宝使用示例，更多详细文档请参考 [yansongda/pay](https://github.com/yansongda/pay)

```php
<?php

namespace frontend\controllers;

use Yii;

class PayController extends Controller
{
    public function actionIndex()
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ];

        $alipay = Yii::$app->pay->getAlipay()->web($order); // 电脑支付
        // $alipay = Yii::$app->pay->getAlipay()->wap($order); // 手机网站支付
        // $alipay = Yii::$app->pay->getAlipay()->app($order); // APP 支付
        // $alipay = Yii::$app->pay->getAlipay()->pos($order); // 刷卡支付
        // $alipay = Yii::$app->pay->getAlipay()->scan($order); // 扫码支付
        // $alipay = Yii::$app->pay->getAlipay()->transfer($order); // 帐户转账
        // $alipay = Yii::$app->pay->getAlipay()->mini($order); // 小程序支付

        return $alipay->send();
    }

    public function actionReturn()
    {
        $data = Yii::$app->pay->getAlipay()->verify();

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function actionNotify()
    {
        $alipay = Yii::$app->pay->getAlipay();
    
        try{
            $data = $alipay->verify();

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Yii::$app->pay->getLog()->debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();
    }
}
```

### 获取微信实例

``` php
Yii::$app->pay->getWechat();
// or
Yii::$app->pay->wechat;
```

### 微信使用示例，更多详细文档请参考 [yansongda/pay](https://github.com/yansongda/pay)

```php
<?php

namespace frontend\controllers;

use Yii;

class PayController extends Controller
{
    public function actionIndex()
    {
        $order = [
            'out_trade_no' => time(),
            'total_fee' => '1', // **单位：分**
            'body' => 'test body - 测试',
            'openid' => 'onkVf1FjWS5SBIixxxxxxx',
        ];

        $pay = Yii::$app->pay->getWechat()->mp($order); // 公众号支付
        // $pay = Yii::$app->pay->getWechat()->miniapp($order); // 小程序支付
        // $pay = Yii::$app->pay->getWechat()->wap($order); // H5 支付
        // $pay = Yii::$app->pay->getWechat()->scan($order); // 扫码支付
        // $pay = Yii::$app->pay->getWechat()->pos($order); // 刷卡支付
        // $pay = Yii::$app->pay->getWechat()->app($order); // APP 支付
        // $pay = Yii::$app->pay->getWechat()->transfer($order); // 企业付款
        // $pay = Yii::$app->pay->getWechat()->redpack($order); // 普通红包
        // $pay = Yii::$app->pay->getWechat()->groupRedpack($order); // 分裂红包

        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function actionNotify()
    {
        $pay = Yii::$app->pay->getWechat();

        try{
            $data = $pay->verify();
            
            Yii::$app->pay->getLog()->debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }
        
        return $pay->success()->send();
    }
}
```

## 测试

``` shell
$ composer test
```

## 相关链接

* [https://github.com/yansongda/pay](https://github.com/yansongda/pay)，[yansongda](https://github.com/yansongda)

## License

[MIT](LICENSE)