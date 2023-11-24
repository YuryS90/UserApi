<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $userRepo
 * @property mixed|null $id
 */
class DeleteController extends AbstractController
{
    protected function run(): Response
    {
        // Удаление - изменение статуса
        $this->userRepo->insertOrUpdate([
            'id' => $this->id ?? null,
            'is_del' => 1,
        ]);

        return $this->redirect('/users');
    }
}