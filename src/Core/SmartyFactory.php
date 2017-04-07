<?php

namespace Petr\Comments\Core;

/**
 * @author Vehsamrak
 */
class SmartyFactory
{
    private static $smarty;

    public static function create(): \Smarty
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
