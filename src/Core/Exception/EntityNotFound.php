<?php

namespace Petr\Comments\Core\Exception;

/**
 * @author Vehsamrak
 */
class EntityNotFound extends HttpNotFound
{

    public function __construct()
    {
        parent::__construct('Entity not found.');
    }
}
