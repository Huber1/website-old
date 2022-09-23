<?php

namespace app\controllers;


class PGPController
{
    function index(): string
    {
        if (isset($_GET['mail']))
            return view('pgp', $this->getKey($_GET['mail']));

        return view('pgp', array_merge(['default' => true], $this->getKey()));
    }

    function mail($email): string
    {
        return view('pgp', $this->getKey($email));
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