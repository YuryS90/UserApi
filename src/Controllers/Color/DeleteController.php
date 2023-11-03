<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteController extends AbstractController
{
    protected function run(): Response
    {
        // сюда прилеатает
        $this->dd($this->args, 'DeleteControllerCOLOR');
        //unset($request['_METHOD']);
        //unset($request['csrf_name']);
        //unset($request['csrf_value']);
        // удаление из бд

        // ретурн редирект список
    }
}