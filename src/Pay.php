<?php

/*
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\YiiPay;

use Yansongda\Pay\Pay as YsdPay;
use yii\base\Component;

/**
 * Class Pay.
 */
class Pay extends Component
{
    /**
     * @var array
     */
    protected $wechatConfig = [];

    /**
     * @var array
     */
    protected $alipayConfig = [];

    /**
     * @return array
     */
    public function getWechatConfig()
    {
        return $this->wechatConfig;
    }

    /**
     * @param array $wechatConfig
     */
    public function setWechatConfig($wechatConfig)
    {
        $this->wechatConfig = $wechatConfig;
    }

    /**
     * @return array
     */
    public function getAlipayConfig()
    {
        return $this->alipayConfig;
    }

    /**
     * @param array $alipayConfig
     */
    public function setAlipayConfig($alipayConfig)
    {
        $this->alipayConfig = $alipayConfig;
    }

    /**
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public function getWechat()
    {
        return YsdPay::wechat($this->wechatConfig);
    }

    /**
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public function getAlipay()
    {
        return YsdPay::alipay($this->alipayConfig);
    }
}
