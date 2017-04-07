<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
class Smarty
{
    private static $smarty;

    private function __construct()
    {
    }

    public static function getInstance(): \Smarty
    {
        if (!self::$smarty) {
            $viewPath = join(DIRECTORY_SEPARATOR, [SRC_PATH, 'View']);
            $templateCompilePath = join(DIRECTORY_SEPARATOR, [SRC_PATH, '..', 'cache']);

            self::$smarty = new \Smarty();
            self::$smarty->setTemplateDir($viewPath);
            self::$smarty->setCompileDir($templateCompilePath);
        }

        return self::$smarty;
    }
}
