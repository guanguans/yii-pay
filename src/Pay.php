<?php

/*
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\YiiPay;

use Yansongda\Pay\Log;
use Yansongda\Pay\Pay as YsdPay;
use Yii;
use yii\base\Component;

/**
 * Class Pay.
 */
class Pay extends Component
{
    /**
     * @var array
     */
    public $wechatOptions = [];

    /**
     * @var array
     */
    public $alipayOptions = [];

    /**
     * @var \Yansongda\Pay\Gateways\Wechat
     */
    private static $_wechat;

    /**
     * @var \Yansongda\Pay\Gateways\Alipay
     */
    private static $_alipay;

    /**
     * @var \Yansongda\Pay\Log
     */
    private $log;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the given configuration.
     */
    public function init()
    {
        parent::init();
        $this->log = Yii::createObject(Log::class);
    }

    /**
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public function getWechat(array $wechatOptions = [])
    {
        $wechatOptions && $this->wechatOptions = array_merge($this->wechatOptions, $wechatOptions);
        if (!static::$_wechat instanceof \Yansongda\Pay\Gateways\Wechat || $wechatOptions) {
            static::$_wechat = YsdPay::wechat($this->wechatOptions);
        }

        return static::$_wechat;
    }

    /**
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public function getAlipay(array $alipayOptions = [])
    {
        $alipayOptions && $this->alipayOptions = array_merge($this->alipayOptions, $alipayOptions);
        if (!static::$_alipay instanceof \Yansongda\Pay\Gateways\Alipay || $alipayOptions) {
            static::$_alipay = YsdPay::alipay($this->alipayOptions);
        }

        return static::$_alipay;
    }

    /**
     * @return object|\Yansongda\Pay\Log
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getLog()
    {
        return $this->log;
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
        return call_user_func_array([$this->log, $method], $arguments);
    }
}
