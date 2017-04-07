<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class ConfigParameterNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct('Entity not found.');
    }
}
