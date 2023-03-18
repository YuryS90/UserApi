<?php

namespace App\Controllers\User;

use Psr\Http\Message\ResponseInterface as Response;

class AddController extends AbstractController
{
    public function run(): Response
    {
        $this->response->getBody()->write('test');

        return $this->response;
    }
}