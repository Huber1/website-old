<?php

namespace app\controllers;

class PGPController
{
    function index(): void
    {
        if (isset($_GET['mail']))
            echo view('pgp', $this->getKey($_GET['mail']));

        $this->echoView(array_merge(['default' => true], $this->getKey()));
    }

    function mail($email): void
    {
        $this->echoView($this->getKey($email));
    }

    private function echoView($data): void
    {
        echo view('pgp', array_merge($data, ['tab' => 'pgp']));
    }

    private function getKey($email = null): array
    {
        $keys = json_decode(file_get_contents(ROOT . '/storage/app/pgp/keys.json'), true);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $email = $email . '@moritzhuber.de';

        if (isset($keys[$email]))
            return ['email' => $email, 'fingerprint' => $keys[$email]];
        else
            return $this->getKey('2nd@moritzhuber.de');
    }
}