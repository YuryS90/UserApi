<?php
use Slim\Factory\AppFactory;

// Не ругается на require(vendor/autoload.php)
chdir(__DIR__ . '/../');

// Подключаем autoload
require 'vendor/autoload.php';

// Создаем приложение
$app = AppFactory::create();

$app->group('', include 'app/routes/root.php');

$app->run();