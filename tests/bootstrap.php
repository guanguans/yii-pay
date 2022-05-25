<?php

/**
 * This file is part of the guanguans/yii-pay.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

define('YII_DEBUG', true);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__.'/main.php';

$app = new yii\console\Application($config);
