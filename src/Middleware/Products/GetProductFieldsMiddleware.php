<?php

namespace App\Middleware\Products;

use App\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Получение данных для отображения таблицы с товарами
 * @property mixed|null $productFieldRepo
 * @property mixed|null productFields
 */
class GetProductFieldsMiddleware extends AbstractMiddleware
{
    const INDEX_ROUTE = 'product.index';
    const SHOW_ROUTE = 'product.show';

    public function run(): ResponseInterface
    {
        if ($this->nameRoute() == self::INDEX_ROUTE ||
            $this->nameRoute() == self::SHOW_ROUTE) {

            // Получаем комментарии в качестве названия полей таблицы
            $columns = $this->productFieldRepo->filter([
                    'fields' => ['COLUMN_COMMENT', 'COLUMN_NAME'],
                    'TABLE_SCHEMA' => true,
                    'TABLE_NAME' => true,
                    'COLUMN_NAME' => ['is_del', 'created', 'updated'],
                ]) ?? [];

            // Формирование в одномерный ассоциативный массив
            $fields = [];
            foreach ($columns as $value) {
                $fields[$value["cOLUMNNAME"]] = $value["cOLUMNCOMMENT"];
            }

            // Обязательный порядок полей для отображения в таблице
            $desiredOrder = unserialize($_ENV['PROD']);

            // Получаем поля в нужном порядке
            uksort($fields, function ($a, $b) use ($desiredOrder) {
                $aIndex = array_search($a, $desiredOrder);
                $bIndex = array_search($b, $desiredOrder);
                return $aIndex - $bIndex;
            });

            // Регистрация отсортированных полей в DI
            $this->productFields = $fields;
        }

        return $this->handle();
    }
}