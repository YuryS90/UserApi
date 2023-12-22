<?php

namespace App\resources;

use Slim\Psr7\Response;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

abstract class AbstractResource implements ResourceInterface
{
    protected static Response $response;

    protected static function respond(int $status, array $data): Response
    {
        self::$response = new Response();

        // Запись ответа в Body
        self::$response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return self::$response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus($status);
    }

    /** @throws \ErrorException */
    public static function dg(...$data): void
    {
        $cloner = new VarCloner();

        $cloner->setMaxItems(-1);

        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        foreach ($data as $var) {

            $data = $cloner->cloneVar($var);
            $dumper->dump($data);
        }
        exit;
    }
}