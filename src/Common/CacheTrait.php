<?php

namespace App\Common;

trait CacheTrait
{
    use ModelTrait;

    /** @throws \Exception */
    public function cache(array $params): ?array
    {
        if (!$this->cacheMod->has($params['key'])) {

            // По умолчанию кешируется весь список
            $list = $this->getAllOrById($params['repo']);
            $this->cacheMod->set($params['key'], $list);
        }

        return $this->cacheMod->get($params['key']);
    }

    public function destroyCache(string $key): void
    {
        if ($this->cacheMod->has($key)) {
            $this->cacheMod->delete($key);
        }
    }
}