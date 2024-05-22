<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;


class StoreController extends AbstractController
{
    private string $renderError = 'user/create.twig';

    protected function run(): Response
    {
        $request = $this->request->getParsedBody();

        unset($request['csrf_name']);
        unset($request['csrf_value']);


        $tagIds = $request['tags'];
        $colorIds = $request['colors'];

        unset($request['tags']);
        unset($request['colors']);


        $this->dd($tagIds);
        $this->insert(self::REPO_PRODUCT, $request);

        // product_tags
        //foreach ($tagIds as $id) {
        //
        //}
        $this->dd('ok');
        //$uploadedFiles = $this->request->getUploadedFiles();

        // Проверка, был ли загружен файл
//        if (isset($uploadedFiles['preview_image'])) {
//            $uploadedFile = $uploadedFiles['preview_image'];
//$this->dd($uploadedFile, $uploadedFile->getClientFilename());
//            // Далее можно обработать загруженный файл, например, переместить его в нужное место
//            $targetPath = __DIR__ . '/../public/uploads/';
//            $uploadedFile->moveTo($targetPath . $uploadedFile->getClientFilename());
        //}//moveUploadedFile

        // $uploadedFile = $uploadedFiles['example1'];
        //    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        //        $filename = moveUploadedFile($directory, $uploadedFile);
        //        $response->write('uploaded ' . $filename . '<br/>');
        //    }

        //$this->dd($request, $this->request->getUploadedFiles());
        // Обработка данных
        //$collection = $this->sanitization($request);
        //$error = $this->validated($collection);
//        if (!empty($error)) {
//
//            // Значит есть недопустимые данные
//            return $this->render($this->renderError, [
//                'error' => $error,
//                'old' => $collection,
//                'roles' => $this->roles ?? [],
//            ]);
//        }

        // TODO как добавлять артикулы, нужно ли их генерировать
        //          если да, то в зависимости от категории? Или это просто набор чисел
        //      Перед добавлением генерировать артикул


        return $this->redirect('/products');
    }
}