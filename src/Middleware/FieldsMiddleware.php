<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

class FieldsMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        // Получаем комментарии
        $columns = $this->schemaRepo->filter([
                'fields' => ['COLUMN_COMMENT', 'COLUMN_NAME'],
                'TABLE_SCHEMA' => true,
                'TABLE_NAME' => true,
                'COLUMN_NAME' => ['password', 'is_del', 'created', 'updated'],
            ]) ?? [];

        // Формирование в одномерный ассоциативный массив
        $fields = [];
        foreach ($columns as $value) {
            $fields[$value["cOLUMNNAME"]] = $value["cOLUMNCOMMENT"];
        }

        // Обязательный порядок полей для отображения в таблице
        $desiredOrder = [
            "id",
            "email",
            "name",
            "address",
            "roles_id",
            "is_email"
        ];

        // Получаем поля в нужном порядке
        uksort($fields, function ($a, $b) use ($desiredOrder) {
            $aIndex = array_search($a, $desiredOrder);
            $bIndex = array_search($b, $desiredOrder);
            return $aIndex - $bIndex;
        });

        // Регистрация отсортированных полей в DI
        $this->fields = $fields;

        return $this->handle();
    }
}