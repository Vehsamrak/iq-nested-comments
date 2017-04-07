<?php

namespace Petr\Comments\Core;

use Petr\Comments\Core\Exception\ActionNotFound;
use Petr\Comments\Core\Exception\ControllerNotFound;

/**
 * Abstract controller. Extend this class to make new controllers.
 * @author Vehsamrak
 */
abstract class AbstractController
{

    private const HTTP_METHOD_POST = 'POST';
    private const HTTP_METHOD_GET = 'GET';

    /** @var Renderer */
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    /**
     * Processing controller action
     * @param string|null $actionName
     * @return mixed
     * @throws ActionNotFound
     */
    public final function processAction($actionName = 'index')
    {
        $fullActionName = $actionName . 'Action';

        if (method_exists(static::class, $fullActionName) && is_callable([static::class, $fullActionName])) {
            return static::$fullActionName();
        } else {
            throw new ActionNotFound();
        }
    }

    /**
     * Template rendering
     * @param string $template
     * @param array $parameters
     */
    public function render($template = 'index', array $parameters = [])
    {
        $this->renderer->render($template, $parameters);
    }

    /**
     * Fetch POST parameters from php://input
     * @return array Post parameters array
     */
    public function getPost(): array
    {
        parse_str(file_get_contents('php://input'), $postParameters);

        return $postParameters;
    }

    /**
     * Get parameter by name. Returns null if parameter was not received
     * @param string $parameterName
     * @return mixed|null
     */
    public function getParameter(string $parameterName)
    {
        $parameterBag = $this->isPost() ? $this->getPost() : $_GET;

        return $parameterBag[$parameterName] ?? null;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->isRequestMethod(self::HTTP_METHOD_POST);
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->isRequestMethod(self::HTTP_METHOD_GET);
    }

    /**
     * @param string $controllerName
     * @param string $action
     * @return mixed
     * @throws ActionNotFound
     * @throws ControllerNotFound
     */
    public function redirectToControllerRoute(string $controllerName, string $action)
    {
        if (!class_exists($controllerName)) {
            throw new ControllerNotFound();
        }
        /** @var AbstractController $controller */
        $controller = new $controllerName;

        return $controller->processAction($action);
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        header(sprintf('Location: %s', $url));
    }

    /**
     * Check request method
     * @param string $method
     * @return bool
     */
    private function isRequestMethod(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }
}
