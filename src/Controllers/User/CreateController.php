<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class CreateController extends AbstractController
{
    protected function run(): Response
    {
        // В Laravel есть метод old, которе испл в инпуте атрибута value
        // value="{{old('age')}}" name="age" - если какое из полей прошло валидацию
        // то делаем чтобы пользователь не вводил дважды допущенную инфу
        // В валидации стоит confirmed - это означает что обязательно должны быть поля
        // У первого в инпуте должно name="password_confirmation", у второго инпута
        // name="password", т.е. у первого должно быть добавлено _confirmation
        // В шаблоне edit убрать поля с паролем, уникальные - с мылом, логином
        // В шаблоне index ссылку на show делаем по имени (логину)


        // Получить роли
        $roles = $this->roleRepo->filter([]);

        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'user/create.twig', [
            'roles' => $roles
        ]);
    }
}