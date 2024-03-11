<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    const REPO = 'tag';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(202, $error);
        }

        $this->insert($collection, self::REPO);

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}