<?php

namespace framework;

class Template
{
    const TO_REPLACE_DATA = "{{[DATA]}}";

    protected string $source;

    public function __construct(string $view, array $toReplaceData = [])
    {
        if (!file_exists(ROOT . '/res/views/' . $view . ".php"))
            return false;
        $this->source = file_get_contents(ROOT . '/res/views/' . $view . ".php");

        // handles includes recursively
        $this->source = $this->handle_includes($this->source);

        foreach ($toReplaceData as $key => $value) {
            switch (gettype($value)) {
                case 'string':
                    $this->replace($key, $value);
                    break;
                case 'array':
                    $this->handle_foreach($value);
                    break;
            }
        }
        return true;
    }

    private function handle_includes(string $file): string
    {
        // search for @extends VIEW and save results as $matches
        preg_match('/(?<=@extends\s)\S+/', $file, $matches);
        if (isset($matches[0])) {
            // remove @extends from file, so it doesn't show up on the page
            $file = str_replace('@extends ' . $matches[0], '', $file);
            // load extended files recursively and replace @content
            $external = $this->handle_includes(file_get_contents(ROOT . '/res/views/' . $matches[0] . '.php'));
            return str_replace('@content', $file, $external);
        } else return $file;
    }

    private function replace($find, $replace): void
    {
        $scheme = str_replace('[DATA]', $find, self::TO_REPLACE_DATA);
        $this->source = str_replace($scheme, $replace, $this->source);
    }

    private function handle_foreach(mixed $value)
    {
        // TODO @foreach
    }

    public function getSource(): string
    {
        return $this->source;
    }
}