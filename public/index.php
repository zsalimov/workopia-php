<?php

require '../helpers.php';
require basePath('Database.php');
require basePath('Router.php');


/**
 * This section moved to routes.php
 */

// $routes = [
//     '/' => 'controllers/home.php',
//     '/listings' => 'controllers/listings/index.php',
//     '/listings/create' => 'controllers/listings/create.php',
//     '404' => 'controllers/error/404.php',
// ];



//instantiating router
$router = new Router();

$routers = require basePath('routes.php');

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);

/**
 * This section moved to router.php
 */
// if (array_key_exists($uri, $routes)) {   
//     require(basePath($routes[$uri]));
// } else {
//     require(basePath($routes['404']));
// }