<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/** Добавление новой записи */
class StoreController extends AbstractController
{
    protected function run(): Response
    {
        // Получение данных
        $request = $this->request->getParsedBody();

        // Их обработка
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(400, $error);
        }

        // Добавление в БД...
        try {
            $this->categoryRepo->insertOrUpdate($collection);
        } catch (\Exception $e) {
             return ResourceError::make(500, $e->getMessage());
        }

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}