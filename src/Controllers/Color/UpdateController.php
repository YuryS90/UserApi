<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/** @property mixed|null $id */
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

        $this->update(self::COLOR, [
            'id' => $this->id ?? null,
            'code' => $collection['code'] ?? null,
        ]);

        return ResourceSuccess::make(200, 'Запись обновлена!');
    }
}