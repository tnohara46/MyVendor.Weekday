<?php

use MyVendor\Weekday\Bootstrap;

require dirname(__DIR__) . '/autoload.php';
exit((new Bootstrap())('cli-prod-hal-api-app', $GLOBALS, $_SERVER));