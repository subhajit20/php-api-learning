<?php

require_once __DIR__ . '/../vendor/autoload.php';
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

// Handle CORS preflight requests
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Create dispatcher
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $user_routes = require __DIR__ . '/../src/routes/routes.php';
    $post_routes = require __DIR__ . '/../src/routes/post.routes.php';
    $user_routes($r);
    $post_routes($r);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Route not found'], JSON_PRETTY_PRINT);
        break;
        
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Method not allowed',
            'allowed_methods' => $allowedMethods
        ], JSON_PRETTY_PRINT);
        break;
        
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        // Handle different types of handlers
        if (is_callable($handler)) {
            // Direct callable (like our root route)
            echo $handler();
        } elseif (is_array($handler) && count($handler) === 2) {
            // Controller class and method
            [$controllerClass, $method] = $handler;
            $controller = new $controllerClass();
            
            // Call the method with route parameters
            if (empty($vars)) {
                echo $controller->$method();
            } else {
                echo $controller->$method(...array_values($vars));
            }
        }
        break;
}