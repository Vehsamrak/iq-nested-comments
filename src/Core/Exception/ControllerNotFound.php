<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class ControllerNotFound extends HttpNotFound
{
    public function __construct()
    {
        parent::__construct('Controller not found.');
    }
}
