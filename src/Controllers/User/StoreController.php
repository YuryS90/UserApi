<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $userRepo
 * @property mixed|null $roles
 */
class StoreController extends AbstractController
{
    private string $renderError = 'user/create.twig';

    protected function run(): Response
    {
        $request = $this->request->getParsedBody() ?? [];

        // Обработка данных
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {

            // Значит есть недопустимые данные
            return $this->render($this->renderError, [
                'error' => $error,
                'old' => $collection,
                'roles' => $this->roles ?? [],
            ]);
        }

        // Добавление в БД
        $this->userRepo->insertOrUpdate($collection);

        return $this->redirect('/users');
    }
}