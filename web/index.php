<?php

use Petr\Comments\Core\ErrorHandler;
use Petr\Comments\Core\Router;

require __DIR__ . '/../vendor/autoload.php';
const SRC_PATH = __DIR__ . '/../src';

$router = new Router();
$errorHandler = new ErrorHandler();

try {
    $router->run();
} catch (\Exception $exception) {
    $errorHandler->handle($exception);
}
