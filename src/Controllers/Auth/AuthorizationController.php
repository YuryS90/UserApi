<?php
//
//namespace App\Controllers\Auth;
//
//use App\Controllers\AbstractController;
//use App\resources\ResourceError;
//use App\resources\ResourceSuccess;
//use Psr\Http\Message\ResponseInterface as Response;
//
//class AuthorizationController extends AbstractController
//{
//    const SLUG = 'auth';
//
//    public function run(): Response
//    {
//        // TODO
//        //      -Изучить JWT
//        //      Распечатать заголовки... Authorization Bearer
//        //      Если срок действия токена истекает, то нужно отправлять пользователя на авторизацию чтобы обновить
//
//
//        // Ловлю почту и пароль
//        $request = ['email' => 'sviridenkoanzela8@gmail.com', 'password' => 'eymF6-j&&ptj']; // Для отладки
//
//        // Обработка данных клиента
//        //$code = $this->validated($request, self::SLUG);
//
//        if (!empty($code)) {
//            return ResourceError::make(401, ['msg' => $code]);
//           // return $this->respondError(401, $message);
//        }
//
//        // Аутентификация пользователя и предоставление токена
//        $token = $this->authMod->auth($request);
//
//        // Проверяем, содержит ли $token токен или сообщение об ошибке
//        if (strpos($token, 'Ошибка') !== false) {
//            return ResourceError::make(401, ['msg' => $token]);
//
//            //$this->dd($token);
//            //return $this->respondError(401, $token);
//        }
//
//        //return $this->respondSuccess(200, self::SLUG, $request, $token);
//        return ResourceSuccess::make(200, ['msg' => self::SLUG, 'token' => $token]);
//    }
//}