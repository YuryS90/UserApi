<?php

namespace App\Modules;

class Generator extends MainModule
{
    /**
     * Генерация пароля
     * @throws \Exception
     */
    public function password(int $length = 10): string
    {
        $characters = $this->generate['password'];
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }
}