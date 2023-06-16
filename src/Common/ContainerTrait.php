<?php

namespace App\Common;

use Psr\Container\ContainerInterface;

trait ContainerTrait
{
    use HelperTrait;

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        if (!$this->container->has($name)) {
            return null;
        }

        return $this->container->get($name);
    }

    public function __set($name, $value)
    {
        $this->container->set($name, $value);
    }
}