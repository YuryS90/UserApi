<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $userRepo
 * @property mixed|null $id
 */
class UpdateController extends AbstractController
{
    private string $renderError = 'user/edit.twig';

    protected function run(): Response
    {
        $this->dd('update');
        $request = $this->request->getParsedBody() ?? [];

        // Обработка данных
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {

            // Значит есть недопустимые данные
            return $this->render($this->renderError, [
                'error' => $error
            ]);
        }

        // Обновляем в БД, передав id
        $this->userRepo->insertOrUpdate([
            'id' => $this->id ?? null,
            'name' => $request['name'] ?? null,
            'address' => $request['address'] ?? null,
            'roles_id' => $request['roles_id'] ?? null,
        ]);

        return $this->redirect('/users');
    }
}