<?php

/**
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Gateways\Alipay;
use Yansongda\Pay\Gateways\Wechat;
use Yansongda\Pay\Log;
use yii\base\InvalidConfigException;

class PayTest extends TestCase
{
    protected $pay;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pay = \Yii::$app->pay;
    }

    public function testGetWechat()
    {
        $this->assertInstanceOf(Wechat::class, $wechatA = $this->pay->getWechat());
        $this->assertInstanceOf(Wechat::class, $wechatB = $this->pay->wechat);
        $this->assertInstanceOf(Wechat::class, $wechatC = $this->pay->getWechat([
            'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
            'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
            'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
            'mch_id' => '14577xxxx',
            'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
            'notify_url' => 'http://xxxxxx.cn/notify.php',
            'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
            'cert_key' => './cert/apiclient_key.pem', // optional，退款等情况时用到
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
        ]));

        $this->assertSame($wechatA, $wechatB);
        $this->assertNotSame($wechatA, $wechatC);
    }

    public function testGetAlipay()
    {
        $this->assertInstanceOf(Alipay::class, $alipayA = $this->pay->getAlipay());
        $this->assertInstanceOf(Alipay::class, $alipayB = $this->pay->alipay);
        $this->assertInstanceOf(Alipay::class, $alipayC = $this->pay->getAlipay([
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
        ]));

        $this->assertSame($alipayA, $alipayB);
        $this->assertNotSame($alipayA, $alipayC);
    }

    public function testGetLog()
    {
        $this->assertInstanceOf(Log::class, $this->pay->getLog());
        $this->assertInstanceOf(Log::class, $this->pay->log);
    }

    public function testCall()
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('The default driver is not set.');
        $this->pay->success();

        \Yii::configure($this->pay, ['defaultDriver' => 'wechat']);
        $this->assertInstanceOf(Response::class, $this->pay->success());

        \Yii::configure($this->pay, ['defaultDriver' => 'alipay']);
        $this->assertInstanceOf(Response::class, $this->pay->success());
    }
}
