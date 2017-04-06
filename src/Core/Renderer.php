<?php

namespace Petr\Comments\Core;

/**
 * Template view renderer
 * @author Vehsamrak
 */
class Renderer
{

    /**
     * Render view template.
     * Parameters are extracted to be used inside template.
     */
    public function render(string $template = 'index', array $parameters = [])
    {
        $templateFileName = $template . '.php';
        $templatePath = join(
            DIRECTORY_SEPARATOR,
            [
                $this->getUserViewDirectory(),
                $templateFileName,
            ]
        );
        extract($parameters);

        require_once($templatePath);
    }

    public static function getUserViewDirectory(): string
    {
        return join(DIRECTORY_SEPARATOR, [SRC_PATH, 'View']);
    }
}
