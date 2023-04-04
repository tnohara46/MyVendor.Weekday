<?php

declare(strict_types=1);

// use MyVendor\Weekday\Bootstrap;
use MyVendor\Weekday\Bootstrap;

// require dirname(__DIR__) . '/autoload.php';
// exit((new Bootstrap())(PHP_SAPI === 'cli-server' ? 'hal-app' : 'prod-hal-app', $GLOBALS, $_SERVER));


require dirname(__DIR__) . '/autoload.php';
exit((new Bootstrap())(PHP_SAPI === 'cli-server' ? 'html-app' : 'prod-html-app', $GLOBALS, $_SERVER));

// JSONアプリケーション （最小）
// require dirname(__DIR__) . '/autoload.php';
// exit((new Bootstrap())('prod-app', $GLOBALS, $_SERVER));

// // プロダクション用HALアプリケーション
// require dirname(__DIR__) . '/autoload.php';
// exit((new Bootstrap())('prod-hal-app', $GLOBALS, $_SERVER));