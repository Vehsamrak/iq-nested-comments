<?php

namespace Petr\Comments\Core;

use Petr\Comments\Core\Exception\ConfigNotFound;
use Petr\Comments\Core\Exception\ConfigParameterNotFound;

/**
 * Application configuration singleton
 * @author Vehsamrak
 */
class Config
{

    /** @var array */
    private static $config;

    private function __construct()
    {
    }

    /**
     * @return mixed
     * @throws ConfigParameterNotFound
     */
    public static function get(string $key)
    {
        if (!self::$config) {
            $configFile = join(DIRECTORY_SEPARATOR, [SRC_PATH, 'config.php']);

            if (!file_exists($configFile)) {
            	throw new ConfigNotFound();
            }

            self::$config = require($configFile);
        }

        if (!isset(self::$config[$key])) {
            throw new ConfigParameterNotFound;
        }

        return self::$config[$key];
    }
}
