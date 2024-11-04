<?php

require '../helpers.php';
// require basePath('Framework/Database.php');
// require basePath('Framework/Router.php');

//Custom Class Autoload

spl_autoload_register(function ($class) {
    $path = basePath('Framework/' . $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
}



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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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