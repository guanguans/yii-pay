<?php

/*
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Yansongda\Pay\Gateways\Alipay;
use Yansongda\Pay\Gateways\Wechat;
use Yansongda\Pay\Log;
use Yii;
use yii\base\InvalidConfigException;

class PayTest extends TestCase
{
    protected $pay;

    protected function setUp()
    {
        parent::setUp();
        $this->pay = Yii::$app->pay;
    }

    public function testGetWechat()
    {
        $this->assertInstanceOf(Wechat::class, $this->pay->getWechat());
        $this->assertInstanceOf(Wechat::class, $this->pay->wechat);
    }

    public function testGetAlipay()
    {
        $this->assertInstanceOf(Alipay::class, $this->pay->getAlipay());
        $this->assertInstanceOf(Alipay::class, $this->pay->alipay);
    }

    public function testGetLog()
    {
        $this->assertInstanceOf(Log::class, $this->pay->getLog());
        $this->assertInstanceOf(Log::class, $this->pay->log);
    }

    public function testCall()
    {
        $mock_string = 'mock_string';
        $mock_array = ['mock_array'];

        $this->assertSame($this->pay->log->log(100, $mock_string), $this->pay->log(100, $mock_string));
        $this->assertSame($this->pay->log->debug($mock_string, $mock_array), $this->pay->debug($mock_string, $mock_array));
        $this->assertSame($this->pay->log->info($mock_string, $mock_array), $this->pay->info($mock_string, $mock_array));
        $this->assertSame($this->pay->log->notice($mock_string, $mock_array), $this->pay->notice($mock_string, $mock_array));
        $this->assertSame($this->pay->log->warning($mock_string, $mock_array), $this->pay->warning($mock_string, $mock_array));
        $this->assertSame($this->pay->log->error($mock_string, $mock_array), $this->pay->error($mock_string, $mock_array));
        $this->assertSame($this->pay->log->critical($mock_string, $mock_array), $this->pay->critical($mock_string, $mock_array));
        $this->assertSame($this->pay->log->alert($mock_string, $mock_array), $this->pay->alert($mock_string, $mock_array));
        $this->assertSame($this->pay->log->emergency($mock_string, $mock_array), $this->pay->emergency($mock_string, $mock_array));
    }

    public function testInvalidWechatOption()
    {
        $config = [
            'id' => 'yii2-pay-app',
            'basePath' => dirname(__DIR__),
            'components' => [
                'pay' => [
                    'class' => 'Guanguans\YiiPay\Pay',
                    'wechatOption' => [],
                    'alipayOption' => [],
                ],
            ],
        ];
        $app = new yii\web\Application($config);
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage(sprintf('Configuration cannot be empty. : %s', 'wechatOption'));
        Yii::$app->pay->getWechat();
    }

    public function testInvalidAlipayOption()
    {
        $config = [
            'id' => 'yii2-pay-app',
            'basePath' => dirname(__DIR__),
            'components' => [
                'pay' => [
                    'class' => 'Guanguans\YiiPay\Pay',
                    'wechatOption' => [],
                    'alipayOption' => [],
                ],
            ],
        ];
        $app = new yii\web\Application($config);
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage(sprintf('Configuration cannot be empty. : %s', 'alipayOption'));
        Yii::$app->pay->getAlipay();
    }
}
