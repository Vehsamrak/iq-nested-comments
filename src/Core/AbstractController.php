<?php

namespace Petr\Comments\Core;

use Petr\Comments\Core\Exception\ActionNotFound;
use Petr\Comments\Core\Exception\ControllerNotFound;

/**
 * Abstract controller
 * @author Vehsamrak
 */
abstract class AbstractController
{

    private const HTTP_METHOD_POST = 'POST';
    private const HTTP_METHOD_GET = 'GET';

    /** @var \Smarty */
    protected $smarty;

    public function __construct()
    {
        $this->smarty = SmartyFactory::create();
    }

    /**
     * Processing controller action
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
     */
    protected function render($template = 'index', array $parameters = [])
    {
        $templateFileName = $template . '.smarty.html';

        $this->smarty->assign($parameters);
        $this->smarty->display($templateFileName);
    }

    /**
     * Fetch POST parameters from php://input
     * @return array Post parameters array
     */
    protected function getPost(): array
    {
        parse_str(file_get_contents('php://input'), $postParameters);

        return $postParameters;
    }

    /**
     * Get parameter by name. Returns null if parameter was not received
     * @return mixed|null
     */
    protected function getParameter(string $parameterName)
    {
        $parameterBag = $this->isPost() ? $this->getPost() : $_GET;

        return $parameterBag[$parameterName] ?? null;
    }

    /**
     * @return bool
     */
    protected function isPost(): bool
    {
        return $this->isRequestMethod(self::HTTP_METHOD_POST);
    }

    /**
     * @return bool
     */
    protected function isGet(): bool
    {
        return $this->isRequestMethod(self::HTTP_METHOD_GET);
    }

    /**
     * @return mixed
     * @throws ActionNotFound
     * @throws ControllerNotFound
     */
    protected function redirectToControllerRoute(string $controllerName, string $action)
    {
        if (!class_exists($controllerName)) {
            throw new ControllerNotFound();
        }
        /** @var AbstractController $controller */
        $controller = new $controllerName;

        return $controller->processAction($action);
    }

    protected function redirect(string $url)
    {
        header(sprintf('Location: %s', $url));
    }

    /**
     * Check request method
     */
    private function isRequestMethod(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }
}
