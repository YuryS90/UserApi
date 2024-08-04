<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    private string $renderError = 'user/create.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        $product = $this->request->getParsedBody();
        $images = $this->request->getUploadedFiles();

        $collection = $this->sanitization($product);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(202, $error);
        }

        // Пришло ли preview_image (главное изображение)
        if (isset($images['preview_image'])) {
            $mainImg = $images['preview_image'];

            // Если файл загружен, то перемещаем в public/images с уникальным именем и добавляем в $product новый элемент
            if ($mainImg->getError() === UPLOAD_ERR_OK) {
                $product['preview_image'] = $this->moveUploadedFile($this->paths['img'], $mainImg);
            }
        }

        $tagsIds = $product['tags'] ?? null;
        $colorsIds = $product['colors'] ?? null;

        // Удаление пустых элементов из-за hidden
        $tagsIds = array_filter($tagsIds, function ($value) {
            return $value !== '' && $value !== null;
        });

        $colorsIds = array_filter($colorsIds, function ($value) {
            return $value !== '' && $value !== null;
        });

        // Удаляем элементы tags и colors, т.к. их нет в табл.`products`
        unset($product['tags']);
        unset($product['colors']);

        // Добавление нового продукта в табл.`products` и его же получение
        $product = $this->insertGet($this->getClassName(), [
            'article' => $product['article']
        ], $product);

        $gallery = [];

        // Пришло ли image_list
        if (isset($images['image_list'])) {
            foreach ($images['image_list'] as $image) {
                // Если файл был загружен, то перемещаем файл в public/images и присваиваем ему уникальное имя
                if ($image->getError() === UPLOAD_ERR_OK) {
                    $gallery[] = $this->moveUploadedFile($this->paths['img'], $image);
                }
            }
        }

        if (!empty($gallery)) {
            foreach ($gallery as $item) {
                // Добавление в табл.`galleries`
                $this->insert(self::REPO_GALLERY, [
                    'image_list' => $item,
                    'product_id' => $product['id']
                ]);
            }
        }

        // К $product['id'] может относиться несколько $tagId
        // TODO Добавить проверку на приходят ли теги
        foreach ($tagsIds as $tagId) {
            // Добавление в табл.`product_tags`
            $this->insert(self::REPO_PRODUCT_TAGS, [
                'tag_id' => $tagId,
                'product_id' => $product['id']
            ]);
        }

        // TODO Добавить проверку на приходят ли цвета
        foreach ($colorsIds as $colorId) {
            // Добавление в табл.`color_products`
            $this->insert(self::REPO_COLOR_PRODUCTS, [
                'color_id' => $colorId,
                'product_id' => $product['id']
            ]);
        }

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}