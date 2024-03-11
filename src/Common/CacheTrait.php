<?php

namespace App\Common;

trait CacheTrait
{
    use ModelTrait;

    /** @throws \Exception */
    public function getCacheCategories(string $key, bool $list = false): array
    {
        if ($list) {
            if (!$this->cacheMod->has($key)) {
                $list = $this->getAllOrSingle(self::CATEGORY);

                $this->cacheMod->set($key, $list);
            }

            return $this->cacheMod->get($key);
        }

        if (!$this->cacheMod->has($key)) {
            $list = $this->getAllOrSingle(self::CATEGORY);

            $categories = $this->buildTree2($list);

            $this->cacheMod->set($key, $categories);
        }

        return $this->cacheMod->get($key);
    }


    public function destroyCache(string $key): void
    {
        if ($this->cacheMod->has($key)) {
            $this->cacheMod->delete($key);
        }
    }
}