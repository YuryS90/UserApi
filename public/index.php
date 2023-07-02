<?php

use Slim\Factory\AppFactory;

// Не ругается на require(vendor/autoload.php)
chdir(__DIR__ . '/../');

// Подключаем autoload
require 'vendor/autoload.php';

// Ручное формирование сервис-контейнера
$containerBuilder = new \DI\ContainerBuilder();

// Определим зависимости проекта
$containerBuilder->addDefinitions(
    'app/builder.php',
    'database/config/phinx.php',
    'app/modules.php',
    'app/models.php',
    'app/config.php',
    //'app/payload.php',
    'app/middlewares.php',
);

$container = $containerBuilder->build();

AppFactory::setContainer($container);

// Создаем приложение
$app = AppFactory::create();

// Это $_POST. Включает парсинг json в getParsedBody()
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->group('', include 'app/routes/root.php')->add('exceptionMiddleware');

$app->addRoutingMiddleware();

$app->run();