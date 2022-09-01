<?php

if (!function_exists('view')) {
    /**
     * @param string $view
     * @param array $data
     * @return void
     */
    function view(string $view, array $data = []): void
    {
        $tpl = new \framework\Template($view, $data);
        print $tpl->getSource();
    }
}