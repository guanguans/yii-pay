<?php

/*
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\YiiPay;

use Guanguans\YiiPay\Traits\Macroable;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay as YsdPay;
use Yii;
use yii\base\Component;

/**
 * Class Pay.
 */
class Pay extends Component
{
    use Macroable;

    /**
     * @var array
     */
    public $wechatOptions = [];

    /**
     * @var array
     */
    public $alipayOptions = [];

    /**
     * @var \Yansongda\Pay\Gateways\Alipay
     */
    protected $alipay;

    /**
     * @var \Yansongda\Pay\Gateways\Wechat
     */
    protected $wechat;

    /**
     * @var \Yansongda\Pay\Log
     */
    protected $log;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the given configuration.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public function getAlipay(array $alipayOptions = [])
    {
        $alipayOptions && $this->alipayOptions = array_merge($this->alipayOptions, $alipayOptions);

        return YsdPay::alipay($this->alipayOptions);
    }

    /**
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public function getWechat(array $wechatOptions = [])
    {
        $wechatOptions && $this->wechatOptions = array_merge($this->wechatOptions, $wechatOptions);

        return YsdPay::wechat($this->wechatOptions);
    }

    /**
     * @return object|\Yansongda\Pay\Log
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getLog()
    {
        return Yii::createObject(Log::class);
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->getLog(), $method], $arguments);
    }
}
