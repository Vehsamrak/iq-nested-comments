<?php

namespace Petr\Comments\Core;

use Petr\Comments\Core\Exception\ActionNotFound;
use Petr\Comments\Core\Exception\ControllerNotFound;

/**
 * @author Vehsamrak
 */
class Router
{

    const DEFAULT_CONTROLLER_NAME = 'default';
    const DEFAULT_ACTION_NAME = 'index';

    /**
     * Starting session and running application
     * @return mixed
     * @throws ControllerNotFound
     * @throws ActionNotFound
     */
    public function run()
    {
        session_start();

        $routes = $this->parseRoutes();
        $controllerName = $this->getControllerName($routes);
        $action = $this->getAction($routes);
        if (!class_exists($controllerName)) {
            throw new ControllerNotFound();
        }

        /** @var AbstractController $controller */
        $controller = new $controllerName;

        return $controller->processAction($action);
    }

    private function parseRoutes(): array
    {
        $pathInfo = $_SERVER['PATH_INFO'] ?? null;

        return $pathInfo ? explode('/', $pathInfo) : [];
    }

    private function getControllerName(array $routes): string
    {
        $route = self::DEFAULT_CONTROLLER_NAME;

        if (isset($routes[1])) {
            $route = strtolower($routes[1]);
        }

        $classPath = explode('\\', __NAMESPACE__);
        array_pop($classPath);
        $newClassPath = implode('\\', $classPath);

        return sprintf('\\%s\\Controller\\%sController', $newClassPath, ucfirst($route));
    }

    private function getAction(array $routes): string
    {
        $action = self::DEFAULT_ACTION_NAME;

        if (isset($routes[2])) {
            $action = strtolower($routes[2]);
        }

        return $action;
    }
}
