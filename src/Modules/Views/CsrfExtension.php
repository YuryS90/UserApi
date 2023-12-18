<?php

namespace App\Modules\Views;

use Slim\Csrf\Guard;
use Slim\Views\TwigExtension;
use Twig\TwigFunction;

class CsrfExtension extends TwigExtension
{
    protected Guard $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('csrf_field', [$this, 'csrfField'])
        ];
    }

    public function csrfField(): string
    {
        $nameKey = $this->guard->getTokenNameKey();
        $name = $this->guard->getTokenName();
        $valueKey = $this->guard->getTokenValueKey();
        $value = $this->guard->getTokenValue();

        return
            "<input type='hidden' name='{$nameKey}' value='{$name}'>
             <input type='hidden' name='{$valueKey}' value='{$value}'>";
    }

}