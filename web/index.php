<?php
// Define Paths
define('PATH_ROOT', dirname(__DIR__));  // /var/www/html/test21
define('PATH_VAR', PATH_ROOT . '/var'); // /var/www/html/test21/var
define('PATH_CACHE', PATH_VAR . '/cache'); // /var/www/html/test21/var/cache
define('PATH_LOG', PATH_VAR . '/logs'); // /var/www/html/test21/var/logs
define('PATH_CONFIG', PATH_ROOT . '/config'); // /var/www/html/test21/config
define('PATH_WEB', PATH_ROOT . '/web'); // /var/www/html/test21/web
define('PATH_VENDOR', PATH_ROOT . '/vendor'); // /var/www/html/test21/vendor
define('PATH_SRC', PATH_ROOT . '/src'); // /var/www/html/test21/src
define('PATH_BOOK', PATH_SRC . '/Book'); // /var/www/html/test21/src/Book
define('PATH_VIEWS', PATH_SRC . '/Book/Views'); // /var/www/html/test21/src/Book/Views
define('DEBUG_MODE', TRUE);

// Autoload
require PATH_VENDOR . '/autoload.php';

// App Init
$app = new Silex\Application();
//require PATH_CONFIG . '/config.php';
require PATH_CONFIG . '/app.php';
//require PATH_CONFIG . '/routes.php';
// Development
$app->run();
/*
ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
*/