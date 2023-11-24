<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

/**
 * @property mixed|null $roleRepo
 * @property array $roles
 */
class GetRolesMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        if (!$this->roles) {
            $this->roles = $this->roleRepo->filter([]) ?? [];
        }

        return $this->handle();
    }
}