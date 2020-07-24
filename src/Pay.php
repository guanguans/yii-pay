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
use yii\base\InvalidConfigException;

/**
 * Class Pay.
 */
class Pay extends Component
{
    use Macroable;

    /**
     * @var array
     */
    public $wechatOption = [];

    /**
     * @var array
     */
    public $alipayOption = [];

    protected $alipay;

    protected $wechat;

    protected $log;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the given configuration.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->log = Yii::createObject(Log::class);

        if ($this->wechatOption) {
            $this->wechat = YsdPay::wechat($this->wechatOption);
        }

        if ($this->alipayOption) {
            $this->alipay = YsdPay::alipay($this->alipayOption);
        }
    }

    /**
     * @return mixed
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getWechat()
    {
        if (empty($this->wechat)) {
            throw new InvalidConfigException(sprintf('Configuration cannot be empty. : %s', 'wechatOption'));
        }

        return $this->wechat;
    }

    /**
     * @return mixed
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getAlipay()
    {
        if (empty($this->alipay)) {
            throw new InvalidConfigException(sprintf('Configuration cannot be empty. : %s', 'alipayOption'));
        }

        return $this->alipay;
    }

    /**
     * @return mixed
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
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->log, $method], $arguments);
    }
}
