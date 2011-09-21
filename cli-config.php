<?php
// bootstrap_doctrine.php
use Doctrine\ORM\Tools\Setup;
require_once "Doctrine/ORM/Tools/Setup.php";
Setup::registerAutoloadPEAR();

$classLoader = new \Doctrine\Common\ClassLoader('fhtt', __DIR__.'/lib');
$classLoader->register();
$isDevMode = true;

//if($isDevMode) {
    $cache = new \Doctrine\Common\Cache\ArrayCache(); 
//} 

$cfg = new \Doctrine\ORM\Configuration();
$cfg->setMetadataCacheImpl($cache);
$cfg->setQueryCacheImpl($cache);
$driver = new \Doctrine\ORM\Mapping\Driver\YamlDriver(array(__DIR__.'/config/yaml'));
$cfg->setMetadataDriverImpl($driver);
$cfg->setProxyDir(__DIR__.'/lib/fhtt/proxies');
$cfg->setProxyNamespace('fhtt\\proxies');

if($isDevMode) {
    $cfg->setAutoGenerateProxyClasses(true);
} else {
    $cfg->setAutoGenerateProxyClasses(false);
}

$conn = include __DIR__.'/config/db.php'; 
$em = \Doctrine\ORM\EntityManager::create($conn, $cfg);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
