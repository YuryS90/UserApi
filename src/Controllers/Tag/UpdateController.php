<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

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

        $this->update(self::REPO_TAG, [
            'id' => $this->id ?? null,
            'title' => $collection['title'] ?? null,
        ]);

        return ResourceSuccess::make(200, 'Запись обновлена!');
    }
}