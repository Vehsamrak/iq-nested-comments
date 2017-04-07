<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
abstract class AbstractRepository
{

    protected $connection;
    protected $idGenerator;

    public function __construct(\PDO $connection, IdGenerator $idGenerator = null)
    {
        $this->connection = $connection;
        $this->idGenerator = $idGenerator ?? new IdGenerator();
    }
}
