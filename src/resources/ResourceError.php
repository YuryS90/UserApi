<?php

namespace App\resources;

use Slim\Psr7\Response;

class ResourceError extends AbstractResource implements ResourceInterface
{
    public static function make(int $status, string $message): Response
    {
        return self::respond($status, [
            'success' => false,
            'message' => $message
        ]);
    }
}