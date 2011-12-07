<?php

namespace fhtt\controller;
require_once __DIR__.'/../../silex.phar';


abstract class REST implements \Silex\ControllerProviderInterface
{
  public function connect(\Silex\Application $app) 
  {
    $controllers = new \Silex\ControllerCollection();

    $controllers->get('/{id}', array($this, 'get'));
    $controllers->get('/', array($this, 'index'));

    return $controllers;
  }
  
  abstract public function get(\Silex\Application $app, $id);
  abstract public function index(\Silex\Application $app);
}
