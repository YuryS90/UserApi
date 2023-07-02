<?php

namespace App\Common;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

trait ControllerTrait
{
    use ContainerTrait;

    public function responseJson(array $data, int $status): ResponseInterface
    {
        $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus($status);
    }

    /**
     * Делаем перезагрузку страницы на указанный адрес
     * @param string $url
     * @return mixed
     */
//    public function redirect(string $url = '/')
//    {
//        $response = new Response();
//        return $response
//            ->withHeader('Location', $url)
//            ->withStatus(302);
//    }
}