<?php
use App\Exception\NotFound;
use Slim\Csrf\Guard;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Не ругается на require(vendor/autoload.php)
chdir(__DIR__ . '/../');

// Подключаем autoload
require 'vendor/autoload.php';

session_start();

// Ручное формирование сервис-контейнера
$containerBuilder = new \DI\ContainerBuilder();

// Определим зависимости проекта
$containerBuilder->addDefinitions(
    'app/framework.php',
    'app/builder.php',
    'database/config/phinx.php',
    'app/modules.php',
    'app/models.php',
    'app/config.php',
    'app/middlewares.php',
);

$container = $containerBuilder->build();

AppFactory::setContainer($container);

// Создаем приложение
$app = AppFactory::create();
$responseFactory = $app->getResponseFactory();

// Register Middleware On Container
$container->set('csrf', function () use ($responseFactory) {
    return new Guard($responseFactory);
});

$twig = Twig::create('templates', ['cache' => false, 'debug' => true]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new \App\Modules\Views\CsrfExtension($container->get('csrf')));
$app->add(TwigMiddleware::create($app, $twig));

// Это $_POST. Включает парсинг json в getParsedBody()
$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

// Register Middleware To Be Executed On All Routes
$app->add('csrf');

// Метод переопределения HTTP запроса, напр из POST в PATCH
$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

$error = $app->addErrorMiddleware(true, true, true);
$error->setErrorHandler(HttpNotFoundException::class, NotFound::class);

$app->group('', include 'app/routes/root.php')
    //->add('checkPathParameterMiddleware')
    ->add('serverMiddleware') // 2
    ->add('exceptionMiddleware'); // 1

$app->run();