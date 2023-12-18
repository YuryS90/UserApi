<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Удаление */
class DeleteController extends AbstractController
{
    protected function run(): Response
    {
        // ПРоверить на родительскую категорию!
        // сюда прилеатает
        $this->dd($this->args, 'DeleteController');

        //unset($request['_METHOD']);
        //unset($request['csrf_name']);
        //unset($request['csrf_value']);
        // удаление из бд

        // ретурн редирект список
    }
}