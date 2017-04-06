<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
abstract class AbstractRepository
{

    protected $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
}
