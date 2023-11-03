<?php

namespace App\resources;

use Slim\Psr7\Response;

interface ResourceInterface
{
    public static function make(int $status, array $data): Response;
    public static function messages(): array;
}