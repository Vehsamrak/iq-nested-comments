<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class ActionNotFound extends HttpNotFound
{
    public function __construct()
    {
        parent::__construct('Controller action not found.');
    }
}
