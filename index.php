<?php
  
require_once __DIR__.'/lib/silex.phar';

$app = new Silex\Application();

$app['autoloader']->registerNamespace('fhtt', __DIR__.'/lib/');
$app['autoloader']->registerNamespace('Symfony', '/usr/share/php/');

$app['debug'] = true;

$app->register(new fhtt\serviceprovider\Doctrine(), array( 
  'doctrine.proxy.namespace' => 'fhtt\\proxies', 
  'doctrine.proxy.dir' => __DIR__.'/lib/fhtt/proxies', 
  'doctrine.annotation.path' => __DIR__.'/config/yaml',
  'doctrine.conn' => include __DIR__.'/config/db.php'
));

$app->get('/', function() use($app) {
  return 'INDEX!';
});

//$app->mount('/module', new fhtt\controller\Module());
$app->mount('/module', new fhtt\controller\Generic('\\fhtt\\entities\\Module'));
$app->mount('/program', new fhtt\controller\Generic('\\fhtt\\entities\\Program'));

$app->run();

