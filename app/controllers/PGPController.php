<?php

namespace app\controllers;

class PGPController
{
    function index(): string
    {
        if (isset($_GET['mail'])) return view('pgp', $this->getKey($_GET['mail']));

        return $this->returnView(array_merge(['default' => true], $this->getKey()));
    }

    function key($fingerprint)
    {
        $fingerprint = str_replace("%20", "", $fingerprint);

        $key = $this->getKeyByFingerprint($fingerprint);

        if ($key) {
            header("Cache-Control: public");
            header("Content-Type: text/plain");
            header("Content-Length: " . filesize($key["filepath"]));
            header("Content-Disposition: attachment; filename=${key["filename"]}");
            readfile($key["filepath"]);
        }

//        return json_encode($key);
    }

    function mail($email): string
    {
        return $this->returnView($this->getKey($email));
    }

    private function getKey($email = null): array
    {
        $keys = json_decode(file_get_contents(ROOT . '/storage/app/pgp/keys.json'), true);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $email = $email . '@moritzhuber.de';

        if (isset($keys[$email])) return ['email' => $email, 'fingerprint' => $keys[$email]["fingerprint"], 'filename' => $keys[$email]["filename"]]; else
            return $this->getKey('2nd@moritzhuber.de');
    }

    private function getKeyByFingerprint($fingerprint): ?array
    {
        $keys = json_decode(file_get_contents(ROOT . '/storage/app/pgp/keys.json'), true);
        $keys = array_filter($keys, function ($item) use ($fingerprint) {
            return $fingerprint == str_replace(" ", "", $item["fingerprint"]);
        });

        $email = array_key_first($keys);
        $fingerprint = $keys[$email]["fingerprint"];

        if (file_exists(ROOT . "/storage/app/pgp/keys/" . $keys[$email]["filename"]))
            return [
                "email" => $email,
                "fingerprint" => $fingerprint,
                "filename" => $keys[$email]["filename"],
                "filepath" => realpath(ROOT . "/storage/app/pgp/keys/" . $keys[$email]["filename"])
            ];
        else
            return null;
    }

    private function returnView($data): string
    {
        return view('pgp', array_merge($data, ['tab' => 'pgp']));
    }
}