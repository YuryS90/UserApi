<?php
//
//namespace App\Controllers\Auth;
//
//use App\Controllers\AbstractController;
//use App\resources\ResourceError;
//use App\resources\ResourceSuccess;
//use Psr\Http\Message\ResponseInterface as Response;
//
//class CreateController extends AbstractController
//{
//    const SLUG = 'register';
//    const CHAR_COUNT = 12;
//
//    /** @throws \Exception */
//    public function run(): Response
//    {
//        // TODO
//        //      *В запросах обязательно указывается заголовок:
//        //          Accept: application/json, */*; q=0.01
//        //      У меня пропускает
//        //        "Accept" => array:1 [▼
//        //              0 => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7"
//        //         ]
//        //      *В ответах 2хх с непустым телом обязательно наличие заголовка ответа
//        //          Content-Type: application/json; charset=UTF-8
//        //      *При наличии тела запроса также обязателен заголовок запроса
//        //          Content-Type: application/json; charset=UTF-8
//        //
//        // Сама строка Accept формируется браузером/клиентом и может немного отличаться от браузера к браузеру,
//        // например, наличием и других форматов типа text/javascript, поэтому нужно проверять не равенство,
//        // а именно вхождение "application/json".
//        //
//        // Если вы используете защиту от CSRF (а лучше бы вам её использовать), то удобнее передавать CSRF-токен
//        // в отдельном заголовке (типа X-CSRF-Token) для всех запросов, а не внедрять вручную в каждый запрос.
//        // Хранить CSRF токен в куках плохо по той причине, что куки можно украсть, в чём собственно и
//        // состоит суть CSRF атаки.
//        // https://habr.com/ru/articles/447322/
//
//
//        // TODO
//        //      Каждый модуль должен возвращать ключ, по которому будет выводиться сообщение об ошибке
//        //      нужно чтобы каждый модуль возвращал единый смысл
//
//
//
//
//        // Получение данных клиента
//        // request = $this->request->getParsedBody();
//        $request = ['login' => "Sp2wN", 'email' => "sviridenkoanzela8@gmail.com",]; // Для отладки
//
//        // Обработка данных клиента
//        $key = $this->validated($request, self::SLUG);
//
//        // Если нет сообщения, то значит ошибок при валидации нет
//        if (!empty($key)) {
//            //return $this->respondError(400, $message);
//            return ResourceError::make(400, ['msg' => $key]);
//        }
//        // Генерация пароля
//        $request['pwd'] = $this->genMod->password(self::CHAR_COUNT);
//
//        // Добавление нового клиента в БД
//        $this->userRepo->insertOrUpdate($request);
//
//        // Отправка письма с паролем новому клиенту
//        $this->mailMod->sendEmail($request);
//
//        //return $this->respondSuccess(201, self::SLUG, $request);
//        // Ресурс занимается тем что собирает массив, который отдаёт в результат
//        return ResourceSuccess::make(201, ['msg' => self::SLUG]);
//    }
//}