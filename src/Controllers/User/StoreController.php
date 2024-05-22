<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    private string $renderError = 'user/create.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        // Получение данных
        $request = $this->request->getParsedBody();

        // Их обработка
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        // Если не прошло валидацию, то возвращаемся снова к форме со старыми данными
        if (!empty($error)) {
            return $this->render($this->renderError, [
                'error' => $error,
                'old' => $collection,
                'roles' => $this->cache([
                    'key' => self::KEY_USER_ROLES,
                    'repo' => self::REPO_ROLE,
                ])
            ]);
        }
        // TODO: return ResourceError::make(202, $error, $collection);

        unset($collection['password_confirmation']);
        $this->insert(self::REPO_USER, $collection);

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}