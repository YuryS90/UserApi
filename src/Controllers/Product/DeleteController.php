<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;


class DeleteController extends AbstractController
{
    protected function run(): Response
    {
        $this->dd('del;');
        // Удаление - изменение статуса
        $this->productRepo->insertOrUpdate([
            'id' => $this->id ?? null,
            'is_del' => 1,
        ]);

        return $this->redirect('/users');
    }
}