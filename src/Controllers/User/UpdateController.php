<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateController extends AbstractController
{
    private string $renderError = 'user/edit.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        // Обработка данных
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {

            // Значит есть недопустимые данные
            return $this->render($this->renderError, [
                'error' => $error
            ]);
        }

        $this->update(self::REPO_USER, [
            'id' => $this->id ?? null,
            'name' => $request['name'] ?? null,
            'address' => $request['address'] ?? null,
            'roles_id' => $request['roles_id'] ?? null,
        ]);

        return ResourceSuccess::make(200, 'Запись обновлена!');
    }
}