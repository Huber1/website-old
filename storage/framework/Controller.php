<?php

namespace framework;

class Controller
{
    public static function tab(): ?string
    {
        return get_called_class()::$tab ?? null;
    }

    function view(string $view, array $data = []): void
    {
        echo view($view, array_merge($data, ['tab' => self::tab()]));
    }
}