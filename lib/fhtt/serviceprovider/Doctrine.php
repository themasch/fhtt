<?php
namespace fhtt\serviceprovider;

require_once __DIR__.'/../../silex.phar';
require_once 'Doctrine/Common/ClassLoader.php';

class Doctrine implements \Silex\ServiceProviderInterface
{
  /**
   * parameter:
   * array( 'doctrine.proxy.dir' => '',
   *        'doctrine.proxy.namespace' => '',
   *        'doctrine.annotation.path' => '',
   *        'doctrine.conn' => array() );
   */
  public function register(\Silex\Application $app)
  {
    $app['doctrine.loader'] = new \Doctrine\Common\ClassLoader('Doctrine');
    $app['doctrine.loader']->register();

    $app['doctrine.cache'] = $app->share(function() { 
      //if($app['debug']) {
      return new \Doctrine\Common\Cache\ArrayCache();
      //}
    });

    $app['doctrine.config'] = $app->share(function($app) {
      $config = new \Doctrine\ORM\Configuration();
      $config->setProxyDir($app['doctrine.proxy.dir']);
      $config->setProxyNamespace($app['doctrine.proxy.namespace']);
      $config->setAutoGenerateProxyClasses($app['debug']);
      $config->setMetadataDriverImpl($app['doctrine.annotation.driver']);
      $config->setMetadataCacheImpl($app['doctrine.cache']);
      $config->setQueryCacheImpl($app['doctrine.cache']);
      return $config;
    });
  
    $app['doctrine.annotation.driver'] = $app->share(function($app) {
      // todo: support other drivers
      return new \Doctrine\ORM\Mapping\Driver\YamlDriver($app['doctrine.annotation.path']);
    });
    
    $app['doctrine.events'] = new \Doctrine\Common\EventManager();

    $app['doctrine.em'] = $app->share(function($app) {
      return \Doctrine\ORM\EntityManager::create($app['doctrine.conn'], $app['doctrine.config'], $app['doctrine.events']);
    });
  }
}

