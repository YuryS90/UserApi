<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Обновление
 * @property mixed|null $id
 */
class UpdateController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(202, $error);
        }

        $this->update(self::CATEGORY, [
            'id' => $this->id ?? null,
            'title' => $collection['title'] ?? null,
            'parent_id' => $collection['parent_id'] ?? null,
        ]);

        // Удаление файлов кеша
        $this->destroyCache(self::CACHE_TREE);
        $this->destroyCache(self::CACHE_CATEGORY_LIST);

        return ResourceSuccess::make(200, 'Запись обновлена!');
    }
}