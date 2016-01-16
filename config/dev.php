<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

// include the prod configuration
require PATH_CONFIG . '/prod.php';

// enable the debug mode
$app['debug'] = DEBUG_MODE;

if ($app['debug']) {
    // Show errors
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    // Disable Show errors
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Local
$app['locale'] = 'en';
$app['session.default_locale'] = $app['locale'];
date_default_timezone_set('Asia/Yekaterinburg');

// Cache
$app['cache.path'] = PATH_CACHE; // /var/www/html/test21/var/cache

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http'; // /var/www/html/test21/var/cache/http

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig'; // /var/www/html/test21/var/cache/twig


$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => PATH_LOG . '/silex_dev.log',
    'monolog.name'  => 'dev',
    ]);