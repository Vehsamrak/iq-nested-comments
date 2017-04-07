<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class HttpNotFound extends \Exception
{

    public function __construct($message = 'Not found.')
    {
        parent::__construct($message, 404);
    }
}
