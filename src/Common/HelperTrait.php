<?php

namespace App\Common;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

trait HelperTrait
{
    public function debug(...$data)
    {
        foreach ($data as $item) {
            new \Ospinto\dBug($item);
        }
        exit();
    }

    /**
     * @throws \ErrorException
     */
    public function dd(...$data)
    {
        $cloner = new VarCloner();

        $cloner->setMaxItems(-1);

        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        foreach ($data as $var) {

            $data = $cloner->cloneVar($var);
            $dumper->dump($data);
        }
        exit;
    }
}