<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $userRepo
 * @property mixed|null $roles
 */
class StoreController extends AbstractController
{
    private string $renderError = 'user/create.twig';

    protected function run(): Response
    {
        $request = $this->request->getParsedBody() ?? [];

        $uploadedFiles = $this->request->getUploadedFiles();

        // Проверка, был ли загружен файл
        if (isset($uploadedFiles['preview_image'])) {
            $uploadedFile = $uploadedFiles['preview_image'];
$this->dd($uploadedFile, $uploadedFile->getClientFilename());
            // Далее можно обработать загруженный файл, например, переместить его в нужное место
            $targetPath = __DIR__ . '/../public/uploads/';
            $uploadedFile->moveTo($targetPath . $uploadedFile->getClientFilename());
        }//moveUploadedFile

        // $uploadedFile = $uploadedFiles['example1'];
        //    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        //        $filename = moveUploadedFile($directory, $uploadedFile);
        //        $response->write('uploaded ' . $filename . '<br/>');
        //    }

        $this->dd($request, $this->request->getUploadedFiles());
        // Обработка данных
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {

            // Значит есть недопустимые данные
            return $this->render($this->renderError, [
                'error' => $error,
                'old' => $collection,
                'roles' => $this->roles ?? [],
            ]);
        }

        // Добавление в БД
        $this->userRepo->insertOrUpdate($collection);

        return $this->redirect('/users');
    }
}