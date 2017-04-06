<?php

namespace Petr\Comments\Controller;

use Petr\Comments\Core\AbstractController;

/**
 * @author Vehsamrak
 */
class DefaultController extends AbstractController
{

    public function indexAction()
    {
        $this->render();
    }
}
