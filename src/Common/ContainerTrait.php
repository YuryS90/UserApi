<?php

namespace App\Common;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

trait ContainerTrait
{
    use HelperTrait;

    private ContainerInterface $container;
    private array $config;

    public function __construct(ContainerInterface $container, $config = [])
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @return mixed|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __get($name)
    {
        if (!$this->container->has($name)) {
            return null;
        }
        return $this->container->get($name);
    }

    public function __set($name, $value): void
    {
        $this->container->set($name, $value);
    }
}