<?php

namespace App\Modules\Cache;

use App\Common\HelperTrait;

class Cache
{
    use HelperTrait;

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function set(string $key, array $data, int $ttl = 3600): bool
    {
        $content = [
            $key => $data,
            'end_time' => ($ttl !== null) ? time() + $ttl : null
        ];

        if (file_put_contents($this->getFile($key), serialize($content))) {
            return true;
        }

        return false;
    }

    public function get(string $key): ?array
    {
        $file = $this->getFile($key);

        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return $content[$key];
            }
            unlink($file);
        }

        return null;
    }


    public function has(string $key): bool
    {
        $file = $this->getFile($key);

        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return true;
            }
            unlink($file);
        }
        return false;
    }

    public function delete(string $key): void
    {
        $file = $this->getFile($key);

        if (file_exists($file)) {
            unlink($file);
        }
    }

    private function getFile(string $key): string
    {
        return $this->path . '/' . md5($key) . '.txt';
    }

    // очищает все файлы кеша
    // в указанной директории.
    //public function flush() {
    //    $files = glob($this->cacheDir . '/*');
    //    foreach ($files as $file) {
    //        if (is_file($file)) {
    //            unlink($file);
    //        }
    //    }
    //}

}