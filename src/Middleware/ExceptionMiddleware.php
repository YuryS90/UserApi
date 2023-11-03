<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class ExceptionMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        try {
            return $this->handle();

        } catch (HttpBadRequestException $exception) {
            return $this->respondException(400, $exception);

        } catch (HttpForbiddenException $exception) {
            return $this->respondException(403, $exception);

        } catch (\Exception $exception) {
            return $this->respondException(500, $exception);

        } catch (\TypeError|\Throwable $exception) {
            return $this->respondException(520, $exception);

        }
    }
}
