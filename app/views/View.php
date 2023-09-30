<?php

namespace App\views;

class View
{
    function __construct($viewName = null)
    {
        if ($viewName)
            require __DIR__ . "/" . $viewName . ".php";
    }

    public function Load($viewName): mixed
    {
        return require __DIR__ . "/" . $viewName . ".php";
    }

    public static function cfun(...$params): View
    {
        return new View(...$params);
    }
}