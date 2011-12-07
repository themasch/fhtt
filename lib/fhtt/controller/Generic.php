<?php
namespace fhtt\controller;
require_once __DIR__.'/REST.php';

class Generic extends REST
{

  public function __construct($entity) 
  {
    $this->e = $entity;
  }

  public function get(\Silex\Application $app, $id)
  {
    return json_encode($app['doctrine.em']->getRepository($this->e)->find($id));
  }

  public function index(\Silex\Application $app)
  {
    return json_encode($app['doctrine.em']->getRepository($this->e)->findAll());
  }
}
