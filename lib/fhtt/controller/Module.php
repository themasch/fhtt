<?php
namespace fhtt\controller;
require_once __DIR__.'/REST.php';

class Module extends REST
{
  public function get(\Silex\Application $app, $id)
  {
    return json_encode($app['doctrine.em']->getRepository('\\fhtt\\entities\\Module')->find($id));
  }

  public function index(\Silex\Application $app)
  {
    return json_encode($app['doctrine.em']->getRepository('\\fhtt\\entities\\Module')->findAll());
  }
}
