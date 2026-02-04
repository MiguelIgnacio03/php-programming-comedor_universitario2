<?php
/**
 * Custom Router Class
 */
class Router {
    private $routes = [];

    /**
     * Add a route to the routing table
     * @param string $route The route URL
     * @param string $controller The controller class name
     * @param string $method The method name in the controller
     * @param string|null $middleware Optional middleware
     */
    public function add($route, $controller, $method, $middleware = null) {
        $this->routes[$route] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
    }

    /**
     * Dispatch the request to the corresponding controller
     * @param string $uri The requested URI
     */
    public function dispatch($uri) {
        // Simple URI cleaning
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
        
        // Remove project folder from URI if present
        $projectFolder = 'Comedor_Universitario';
        if (strpos($uri, $projectFolder) === 0) {
            $uri = trim(substr($uri, strlen($projectFolder)), '/');
        }

        // Default to home if empty
        if ($uri === '') {
            $uri = 'home';
        }

        if (array_key_exists($uri, $this->routes)) {
            $route = $this->routes[$uri];
            $controllerName = $route['controller'];
            $methodName = $route['method'];

            // Require the controller file
            $controllerFile = APPROOT . '/app/controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                
                // Instantiate and call the method
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $methodName)) {
                        call_user_func([$controller, $methodName]);
                    } else {
                        die("Method $methodName not found in controller $controllerName");
                    }
                } else {
                    die("Controller class $controllerName not found");
                }
            } else {
                die("Controller file not found: $controllerFile");
            }
        } else {
            // 404 Not Found
            http_response_code(404);
            echo "<h1>404 - Not Found</h1>";
        }
    }
}
