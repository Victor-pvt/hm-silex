<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 22:41
 */
use Doctrine\ORM\EntityManager,
    Doctrine\Common\Annotations\AnnotationRegistry;

$cache = new Doctrine\Common\Cache\ArrayCache;
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader;

$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
    $annotationReader, // use reader
    $cache // and a cache driver
);

$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    $cachedAnnotationReader, // our cached annotation reader
    array(PATH_SRC, PATH_BOOK)
);

$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
$driverChain->addDriver($annotationDriver, 'Entity');

$config = new Doctrine\ORM\Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(TRUE); // this can be based on production config.
// register metadata driver
$config->setMetadataDriverImpl($driverChain);
// use our allready initialized cache driver
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

AnnotationRegistry::registerFile(PATH_ROOT . DIRECTORY_SEPARATOR .
    'vendor' . DIRECTORY_SEPARATOR .
    'doctrine' . DIRECTORY_SEPARATOR .
    'orm' . DIRECTORY_SEPARATOR .
    'lib' . DIRECTORY_SEPARATOR .
    'Doctrine' . DIRECTORY_SEPARATOR .
    'ORM' . DIRECTORY_SEPARATOR .
    'Mapping' . DIRECTORY_SEPARATOR .
    'Driver' . DIRECTORY_SEPARATOR .
    'DoctrineAnnotations.php');

$evm = new Doctrine\Common\EventManager();
$em = EntityManager::create(
    array(
        'driver' => $app['db.options']['driver'],
        'host' => $app['db.options']['host'],
        'port' => $app['db.options']['port'],
        'user' => $app['db.options']['user'],
        'password' => $app['db.options']['password'],
        'dbname' => $app['db.options']['dbname'],
        'charset' => $app['db.options']['charset'],
    ),
    $config,
    $evm
);
