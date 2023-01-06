<?php

/**
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\YiiPay;

use Yansongda\Pay\Log;
use Yansongda\Pay\Pay as YsdPay;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * @property string                         $defaultDriver
 * @property \Yansongda\Pay\Gateways\Wechat $wechat
 * @property \Yansongda\Pay\Gateways\Alipay $alipay
 * @property \Yansongda\Pay\Log             $log
 *
 * @method \Symfony\Component\HttpFoundation\Response         app(array $config)          APP 支付
 * @method \Yansongda\Supports\Collection                     groupRedpack(array $config) 分裂红包
 * @method \Yansongda\Supports\Collection                     miniapp(array $config)      小程序支付
 * @method \Yansongda\Supports\Collection                     mp(array $config)           公众号支付
 * @method \Yansongda\Supports\Collection                     pos(array $config)          刷卡支付
 * @method \Yansongda\Supports\Collection                     redpack(array $config)      普通红包
 * @method \Yansongda\Supports\Collection                     scan(array $config)         扫码支付
 * @method \Yansongda\Supports\Collection                     transfer(array $config)     企业付款
 * @method \Symfony\Component\HttpFoundation\RedirectResponse wap(array $config)          H5 支付
 * @method \Symfony\Component\HttpFoundation\Response         web(array $config)          电脑支付
 * @method \Yansongda\Supports\Collection                     mini(array $config)         小程序支付
 *
 * @see \Yansongda\Pay\Gateways\Wechat
 * @see \Yansongda\Pay\Gateways\Alipay
 */
class Pay extends Component
{
    /**
     * @var string
     */
    private $defaultDriver;

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
        $this->log = \Yii::createObject(Log::class);
    }

    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->defaultDriver;
    }

    /**
     * @param string $defaultDriver
     */
    public function setDefaultDriver($defaultDriver)
    {
        if (! in_array($defaultDriver, ['wechat', 'alipay'])) {
            throw new InvalidConfigException("Invalid default driver(wechat/alipay): $defaultDriver");
        }

        $this->defaultDriver = $defaultDriver;
    }

    /**
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public function getWechat(array $wechatOptions = [])
    {
        $wechatOptions and $this->wechatOptions = array_merge($this->wechatOptions, $wechatOptions);
        if (! static::$_wechat instanceof \Yansongda\Pay\Gateways\Wechat || $wechatOptions) {
            static::$_wechat = YsdPay::wechat($this->wechatOptions);
        }

        return static::$_wechat;
    }

    /**
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public function getAlipay(array $alipayOptions = [])
    {
        $alipayOptions and $this->alipayOptions = array_merge($this->alipayOptions, $alipayOptions);
        if (! static::$_alipay instanceof \Yansongda\Pay\Gateways\Alipay || $alipayOptions) {
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
        if (is_null($this->defaultDriver)) {
            throw new InvalidConfigException('The default driver is not set.');
        }

        return call_user_func_array([$this->{$this->defaultDriver}, $method], $arguments);
    }
}
