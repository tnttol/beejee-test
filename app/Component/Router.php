<?php

namespace App\Component;

use Exception;

/**
 * Class Router
 */
class Router
{
    /** @var array */
    private $routes;

    /**
     * Router constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return string
     */
    private function getURI(): string
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'] ?? '');

        return $uri[0];
    }

    public function run(): void
    {
        $uri = $this->getURI();
        $hasMatches = false;

        if (isset($this->routes[$uri])) {
            $path = $this->routes[$uri];

            $segments = explode('/', $path);
            $controller = array_shift($segments) . 'Controller';
            $action = array_shift($segments) . 'Action';
            $hasMatches = $this->callAction($controller, $action);
        }

        if (!$hasMatches) {
            $this->pageNotFound($uri);
        }
    }

    /**
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    private function callAction(string $controller, string $action): bool
    {
        $class = 'App\\Controller\\' . ucfirst($controller);
        $object = new $class;

        if (method_exists($object, $action)) {
            $object->$action();
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    private function pageNotFound(string $router): void
    {
        throw new Exception('Page "' . $router . '" not found', 404);
    }
}
