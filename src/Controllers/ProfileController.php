<?php

namespace App\Controllers;

use App\resources\ResourceSuccess;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController extends AbstractController
{
    const SLUG = 'profile';

    public function run(): Response
    {
        //$this->dd($this->request->getHeaders());

        // request = $this->request->getParsedBody();
        $request = ['token' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJteV9pc3N1ZXIiLCJhdWQiOiJteV9hdWRpZW5jZSIsImlhdCI6MTY5MzMwMTM4MywibmJmIjoxNjkzMzAxMzgzLCJleHAiOjE2OTMzMDQ5ODMsImRhdGEiOnsiaWQiOjk5LCJsb2dpbiI6IlNwMndOIiwiZW1haWwiOiJzdmlyaWRlbmtvYW56ZWxhOEBnbWFpbC5jb20iLCJyb2xlc0lkIjozfX0.wHwpvmXefzFI0BUMIoxW8RdBxLr5Wi1Y1WhDNHAG_ko"]; // Для отладки


        try {
            $decoded = JWT::decode($request['token'], new Key("my_secret_key", 'HS256'));
//$this->dd($decoded);
            //return $this->respondSuccess(200, self::SLUG, $request, $decoded->data);
            return ResourceSuccess::make(200, ['slug' => self::SLUG, 'data' => $decoded->data]);

        } catch (Exception $e) {
            $this->dd(123);
        }

        return $this->respondError(401, 'sa');

    }
}