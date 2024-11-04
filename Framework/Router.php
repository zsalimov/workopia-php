<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
    protected $routes = [];
    /**
     * Add a new route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] =  [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }
    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller, $middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }
    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller, $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }
    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller, $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Load error pages
     * 
     * @param int $httpCode
     * @return void
     */
    public function error($httpCode = 404)
    {
        http_response_code($httpCode);
        loadView("error/{$httpCode}");
        exit;
    }
    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //check for request method
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            //Override the request method with its value
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            //split the current uri into segments
            $uriSegments = explode("/", trim($uri, '/'));

            //Split the route uri into segments
            $routeSegments = explode("/", trim($route['uri'], '/'));

            $match = true;
            //Check if the number of segments matches
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                 if  ($match) {
                    foreach ($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
                    }

                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    //Instantiate controller and call method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                 }
            
        }

        
    }
    ErrorController::notFound();
}

// $routes = require basePath('routes.php');

// if (array_key_exists($uri, $routes)) {   
//     require(basePath($routes[$uri]));
// } else {
//     http_response_code(404);
//     require(basePath($routes['404']));
}