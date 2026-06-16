<?php

ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__).'/var/log/php_errors.log');
error_reporting(E_ALL);

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
