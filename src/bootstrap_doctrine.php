<?php

$conf_dir = dirname(__DIR__) . '/conf';
$conf = parse_ini_file($conf_dir . '/conf.ini', true);
/**
 * This file included at {$src_dir}/cli-config.php
 * 
 * $src_dir & $tab_conf & $result_cache_conf populated there
 * 
 * This uses the internal (vendor's dir) doctrine2.  if you are using a central
 * doctrine2 install see point there instead
 *
 * See http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/configuration.html
 * for up to date auto-loading details.
 *
 * This was initially mostly cobbled together from
 * https://github.com/l3pp4rd/DoctrineExtensions/blob/2.2.x/example/em.php
 *
 */
$connection = array(
    'driver'   => "pdo_mysql",
    'host'     => $conf['database']['host'],
    'port'     => isset($conf['database']['port']) ? $conf['database']['port'] : '3306',
    'user'     => $conf['database']['user'],
    'password' => $conf['database']['password'],
    'dbname'   => $conf['database']['name'],
    'driverOptions' => array(
        1002=>'SET NAMES utf8'
    )
);

$doc_dir = dirname(__DIR__) . "/src/vendor/doctrine2/";

// First of all auto-loading of vendors
require_once $doc_dir . "/lib/Doctrine/ORM/Tools/Setup.php";
use Doctrine\ORM\Tools\Setup;
$lib = $doc_dir;
Doctrine\ORM\Tools\Setup::registerAutoloadGit($lib);

/*
 * cannot use class loader for Symfony\Component\Validator since
 * Setup::registerAutoloadGit above registers the Symfony\Component namespace
 * We add Symfony\Component\Validator to our phpab loader instead
 */
//$loader = new ClassLoader('Symfony\Component\Validator', $symfony_validator_path);
//$loader->register();

$config = new Doctrine\ORM\Configuration;
// @see http://doctrine-orm.readthedocs.org/en/latest/reference/configuration.html?highlight=proxy#proxy-objects
$config->setProxyDir(sys_get_temp_dir());
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(false);

// standard annotation reader
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader;

// standard doctrine annotations
Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    $doc_dir . "/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php"
);
// register annotation driver
$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();

$src_dir = __DIR__;
$entity_dirs = array_map(
    function($_val) use($src_dir)
    {
        return "{$src_dir}/{$_val}";
    },
    array("entity")
);

//$entity_dirs = array_merge($entity_dirs, array($gedmoPath.'/Gedmo/Translatable/Entity',
//    $gedmoPath.'/Gedmo/Loggable/Entity',
//    $gedmoPath.'/Gedmo/Tree/Entity')
//);

$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver($annotationReader, $entity_dirs);

$driverChain->addDriver($annotationDriver, 'DrinkApp\Entity');

// register metadata driver
$config->setMetadataDriverImpl($driverChain);
/*
 * Configure Doctrine Caches as per conf.php
 * SEE http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html
 */
$config->setMetadataCacheImpl(new Doctrine\Common\Cache\ArrayCache);
$config->setQueryCacheImpl(new Doctrine\Common\Cache\ArrayCache);

// Create a request-based ArrayCache object in the event that result caching is off.
$config->setResultCacheImpl(new \Doctrine\Common\Cache\ArrayCache);

$evm = new Doctrine\Common\EventManager();

// mysql set names UTF-8
//$evm->addEventSubscriber(new Doctrine\DBAL\Event\Listeners\MysqlSessionInit());
// create entity manager
$_em =  Doctrine\ORM\EntityManager::create($connection, $config, $evm);
/*
 * this validator needs ref to em.
 */

return $_em;