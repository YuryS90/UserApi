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
    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(400, $error);
        }

        try {
            $this->categoryRepo->insertOrUpdate([
                'id' => $this->id ?? null,
                'title' => $collection['title'],
                'parent_id' => $collection['parent_id'],
            ]);
        } catch (\Exception $e) {
            return ResourceError::make(500, $e->getMessage());
        }

        return ResourceSuccess::make(200, 'Запись обновлена!');
    }
}