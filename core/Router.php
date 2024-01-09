<?php
// core/Router.php

class Router
{
    protected $routes = [];

    public function addRoute($method, $route, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function route($url, $method)
    {
        // Split the URL into segments
        $urlParts = explode('/', $url);

        foreach ($this->routes as $routeInfo) {
            // Split the route into segments
            $routeParts = explode('/', $routeInfo['route']);
            if (count($urlParts) === count($routeParts) && $method === $routeInfo['method']) {
                $match = true;
                $params = [];

                foreach ($routeParts as $key => $part) {
                    if ($part !== $urlParts[$key] && strpos($part, ':') !== false) {
                        $params[ltrim($part, ':')] = $urlParts[$key];
                    } elseif ($part !== $urlParts[$key]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {
                    $controllerName = $routeInfo['controller'];
                    $actionName = $routeInfo['action'];

                    // Include the controller and call the action
                    require_once 'app/controllers/' . $controllerName . '.php';
                    $controllerInstance = new $controllerName;

                    // Pass the parameters to the action
                    call_user_func_array([$controllerInstance, $actionName], $params);
                    return;
                }
            }
        }

        // Handle 404 or other error
        // You can redirect to a 404 page or take other actions here
    }

}


?>