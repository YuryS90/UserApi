<?php

namespace App\Common;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

trait ContainerTrait
{
    use HelperTrait;

    protected ContainerInterface $container;
    protected array $config;

    public function __construct(ContainerInterface $container, array $config = [])
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @return mixed|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __get(string $name)
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