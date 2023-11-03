<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class UpdateController extends AbstractController
{
    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        // валидация
        //$data = $this->validate($request)
        unset($request['_METHOD']);
        unset($request['csrf_name']);
        unset($request['csrf_value']);
        // обновлем в бд
        $this->colorRepo->insertOrUpdate([
            'id' => $this->args['color'],
            'title' => $request['title'],
        ]);

        $id = $this->args['id'] = $this->args['color'];
        $request['id'] = $id;
        unset($request['_METHOD']);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'color/show.twig', [
            'color' => $request,
        ]);
    }
}