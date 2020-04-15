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

class PayTest extends TestCase
{
    protected $pay;

    protected function setUp()
    {
        parent::setUp();
        $this->pay = Yii::$app->pay;
    }

    public function testSetWechat()
    {
        $config = ['mac_str'];
        $this->pay->setWechat($config);
        $this->assertSame($config, $this->pay->wechat);
    }

    public function testSetAlipay()
    {
        $config = ['mac_str'];
        $this->pay->setAlipay($config);
        $this->assertSame($config, $this->pay->alipay);
    }

    public function testWechat()
    {
        $this->assertInstanceOf(Wechat::class, $this->pay->wechat());
    }

    public function testAlipay()
    {
        $this->assertInstanceOf(Alipay::class, $this->pay->alipay());
    }

    public function testLog()
    {
        $this->assertInstanceOf(Log::class, $this->pay->log());
    }
}
