<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        // Получение данных
        $request = $this->request->getParsedBody();

        // Их обработка
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(202, $error);
        }

        $this->insert(self::COLOR, $collection);

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}