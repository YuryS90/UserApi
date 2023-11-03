<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Обновление */
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
        $this->categoryRepo->insertOrUpdate([
            'id' => $this->args['category'],
            'title' => $request['title'],
        ]);

        $id = $this->args['id'] = $this->args['category'];
        $request['id'] = $id;

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'category/show.twig', [
            'category' => $request,
        ]);
    }
}