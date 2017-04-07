<?php

namespace Petr\Comments\Core;

/**
 * Database abstraction
 * @author Vehsamrak
 */
class Database
{

    /** @var \PDO */
    private $connection;

    /** @inheritdoc */
    public function __construct()
    {
        $dsn = sprintf(
            '%s:host=%s;dbname=%s',
            Config::get('database_type'),
            Config::get('database_host'),
            Config::get('database_name')
        );
        $this->connection = new \PDO(
            $dsn,
            Config::get('database_user'),
            Config::get('database_password'),
            [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
        );
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}
