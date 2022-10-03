<?php

namespace framework;

class Env
{
    static array $env;

    static function parse(): void
    {
        static::$env = parse_ini_file(ROOT . '/.env');
    }

    static function get(string $key): string|null
    {
        return static::$env[$key] ?? null;
    }
}