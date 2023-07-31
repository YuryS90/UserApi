<?php
declare(strict_types=1);

/**
 * CallableResolver - механизм для преобразования различных форматов callable в единый стандартный формат,
 * который Slim может использовать при обработке запросов.
 * Типы callable (объект или функция, которую можно вызвать) в PHP:
 * - строка (имя функции) - 'myFunction';
 * - массив (содержащий класс и метод в виде строки или объекта и названия метода) - [MyClass::class, 'myMethod'];
 * - замыкание (closure) - анонимная функция -
 * $callable = function($name){
 * echo "Hello, $name!";
 * };.
 * Например, передан массив CallableResolver ИЗВЛЕКАЕТ имя класса и название метода из массива
 * и создает объект класса с помощью вызова соответствующего метода.
 * Например, передана строка CallableResolver просто вызывает функцию с этим именем.
 * Вывод: когда Slim4 получает обработчик, то передает его объекту Slim\CallableResolver
 * Resolver проверяет тип callable и преобразует его в единый формат
 * Результатом работы Slim\CallableResolver является обработчик (handler), который можно вызвать,
 * передав необходимые аргументы, если они присутствуют
 */

return [

    \Slim\Interfaces\CallableResolverInterface::class => function () {
        return new \Slim\CallableResolver();
    },

    \Psr\Http\Message\ResponseFactoryInterface::class => function () {
        return new \Slim\Psr7\Factory\ResponseFactory();
    },

    \Psr\Log\LoggerInterface::class => function () {
        return new \Slim\Logger('app');
    },

];
