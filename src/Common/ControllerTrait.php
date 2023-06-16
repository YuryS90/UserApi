<?php

namespace App\Common;

use Psr\Http\Message\ResponseInterface;

trait ControllerTrait
{
    use ContainerTrait;

    public function responseJson(array $data, int $status): ResponseInterface
    {
        $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}