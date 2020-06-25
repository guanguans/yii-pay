<?php

/*
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\YiiPay\Traits;

use BadMethodCallException;
use Closure;
use ReflectionClass;
use ReflectionMethod;
use yii\base\InvalidArgumentException;

/**
 * This file is modified from `spatie/macroable`.
 *
 * @see https://github.com/spatie/macroable
 * Trait Macroable.
 */
trait Macroable
{
    protected static $macros = [];

    /**
     * Register a custom macro.
     *
     * @param $name
     * @param $macro object|callable $macro
     */
    public static function macro($name, $macro)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(sprintf('Argument type must be a string: %s', gettype($name)));
        }
        static::$macros[$name] = $macro;
    }

    /**
     * Mix another object into the class.
     *
     * @param object $mixin
     *
     * @throws \ReflectionException
     */
    public static function mixin($mixin)
    {
        $methods = (new ReflectionClass($mixin))->getMethods(
            ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            $method->setAccessible(true);

            static::macro($method->name, $method->invoke($mixin));
        }
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function hasMacro($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(sprintf('Argument type must be a string: %s', gettype($name)));
        }

        return isset(static::$macros[$name]);
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf('Method %s does not exist.', $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array(Closure::bind($macro, null, static::class), $parameters);
        }

        return call_user_func_array($macro, $parameters);
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf('Method %s does not exist.', $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $parameters);
        }

        return call_user_func_array($macro, $parameters);
    }
}
