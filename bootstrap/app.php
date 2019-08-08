<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

$app = new Slim\App(include __DIR__ . '/config.php');
$container = $app->getContainer();

require __DIR__ . '/database.php';
require __DIR__ . '/register.php';
require __DIR__ . '/render.php';

$app->add(new App\Middleware\AllowOriginMiddleware($container));

require __DIR__ . '/../routes/api.php';
require __DIR__ . '/../routes/web.php';