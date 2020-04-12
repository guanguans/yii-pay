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
    protected $wechat = [];

    /**
     * @var array
     */
    protected $alipay = [];

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the given configuration.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function getWechat()
    {
        return $this->wechat;
    }

    /**
     * @param array $wechat
     */
    public function setWechat($wechat)
    {
        $this->wechat = $wechat;
    }

    /**
     * @return array
     */
    public function getAlipay()
    {
        return $this->alipay;
    }

    /**
     * @param array $alipay
     */
    public function setAlipay($alipay)
    {
        $this->alipay = $alipay;
    }

    /**
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public function wechat()
    {
        return YsdPay::wechat($this->wechat);
    }

    /**
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public function alipay()
    {
        return YsdPay::alipay($this->alipay);
    }
}
