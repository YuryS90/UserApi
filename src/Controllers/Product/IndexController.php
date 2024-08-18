<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    // Количество данных на n-й стр
    const LIMIT = 5;

    private array $fields = ['id', 'article', 'brand', 'preview_image', 'new_price', 'count'];

    private string $template = 'product/index.twig';

    protected function run(): Response
    {
        // TODO Нужно сделать валидацию на ?page, иначе вместо этого можно прописать всё что угодно
        //      также проверить если страницу 5, то проверить что будет если ввести не существующую 6 стр
        //      Также для каждого контроллера сделать входные данные, например правила валидации
        //      количество страниц (сколько LIMIT, PAGE_NUM, MID_SIZE)
        //      Валидировать ?page=2рп


        // Получаем страницу, по которой кликнули
        $currentPage = $this->getQueryParams()['page'] ?? null;
        $currentPage = (!empty($currentPage) && $currentPage > 0) ? intval($currentPage) : 1;

        // Получаем всего записей в таблице, а после всего страниц (totalPages)
        $count = $this->productRepo->getCount();
        $totalPages = intval(ceil($count / self::LIMIT));

        // Если, например страниц больше чем есть, то 1  ?page=10000, то ?page=1
        if ($totalPages < $currentPage) {
            $currentPage = 1;
        }

        return $this->render($this->template, [
            // Передаём конкретные поля
            'fields' => $this->getSpecificColumns(self::REPO_PRODUCT, $this->fields),

            // Количество записей для n-й страницы
            'products' => $this->getByParams(self::REPO_PRODUCT, [
                'fields' => $this->fields,
                'orderByIdDesc' => true,
                'limit' => self::LIMIT,
                'offset' => ($currentPage - 1) * self::LIMIT,
            ]),

            // Текущая страница
            'currentPage' => $currentPage,

            // Всего страниц
            'totalPages' => $totalPages,
        ]);
    }
}