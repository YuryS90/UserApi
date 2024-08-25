<?php
use App\Exception\NotFound;
use Slim\Csrf\Guard;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

ini_set('log_errors', true);
ini_set('error_log', 'error_log');
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

// Не ругается на require(vendor/autoload.php)
chdir(__DIR__ . '/../');

// Если это источник, с которого разрешены запросы, то добавляем заголовки CORS
// Если запрос содержит учетные данные (файлы cookie, заголовки авторизации или клиентские сертификаты TLS)
// то Access-Control-Allow-Credentials:true
if (!empty($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === 'http://localhost:5173') {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
}

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
//*$container->set('csrf', function () use ($responseFactory) {
//    return new Guard($responseFactory);
//});

$twig = Twig::create('templates', ['cache' => false, 'debug' => true]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
//*$twig->addExtension(new \App\Modules\Views\CsrfExtension($container->get('csrf')));
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();

// Register Middleware To Be Executed On All Routes
//$app->add('csrf');

// Метод переопределения HTTP запроса, напр из POST в PATCH
$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware);

// Это $_POST. Включает парсинг json в getParsedBody()
$app->addBodyParsingMiddleware();
$error = $app->addErrorMiddleware(true, true, true);
$error->setErrorHandler(HttpNotFoundException::class, NotFound::class);

$app->group('', include 'app/routes/root.php')
    ->add('checkPathParameterMiddleware')
    ->add('serverMiddleware') // 3
    ->add('exceptionMiddleware');  // 2
    //*->add('csrf');  // 1

$app->run();