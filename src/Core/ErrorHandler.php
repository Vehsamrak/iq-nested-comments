<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
class ErrorHandler
{

    /** @var Renderer */
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function handle(\Exception $exception)
    {
        $this->renderException($exception);
    }

    /**
     * @throws Exception\ConfigParameterNotFound
     */
    private function renderException(\Exception $exception)
    {
        $templatePath = join(
            DIRECTORY_SEPARATOR,
            [
                Renderer::getUserViewDirectory(),
                'error',
                'error.php',
            ]
        );

        $this->sendHeaders($exception);

        require_once($templatePath);
    }

    private function sendHeaders(\Exception $exception)
    {
        header(sprintf('HTTP/1.1 %d %s', $exception->getCode(), $exception->getMessage()));
    }
}
