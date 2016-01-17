<?php

use Symfony\Component\Debug\Debug;
use Silex\Application;

require PATH_CONFIG . '/dev.php';
require PATH_CONFIG . '/doctrine.php';

if(DEBUG_MODE){
    Debug::enable();
}


$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\HttpCacheServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider());
//$app->register(new Silex\Provider\SymfonyBridgesServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale' => $app['locale'],
)) ;

// Template Engine Definition
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
        'debug' => $app['debug']
    ),
    'twig.path' => array(PATH_VIEWS),
));

$app['bookService'] = function() use ($em, $app){
    $bookService = new \Service\BookService($em, new \Entity\Book($app), $app);

    return $bookService;
};

// Errors Exception
$app->error(function(\Exception $e, $code) use($app) {

    $file = pathinfo($e->getFile());

    return $app->json([
        'success' => false,
        'message' => 'Error',
        'error' => $e->getMessage(),
        'serverror' => $code,
        'source' => $file['filename'],
        'line' => $e->getLine()
    ], $code);
});

require PATH_CONFIG . '/routes.php';

/*

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
}));

return $app;
*/