<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
class ErrorHandler
{

    /** @var \Smarty */
    private $smarty;

    public function __construct()
    {
        $this->smarty = Smarty::getInstance();
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
        $this->sendHeaders($exception);

        $this->smarty->assign(['exception' => $exception]);
        $this->smarty->display('error/error.smarty.html');
    }

    private function sendHeaders(\Exception $exception)
    {
        header(sprintf('HTTP/1.1 %d %s', $exception->getCode(), $exception->getMessage()));
    }
}
