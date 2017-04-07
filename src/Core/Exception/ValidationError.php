<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class ValidationError extends \Exception
{

    public function __construct(string $parameter)
    {
        $message = sprintf('Mandatory parameter missed: "%s".', $parameter);

        parent::__construct($message, 400);
    }
}
