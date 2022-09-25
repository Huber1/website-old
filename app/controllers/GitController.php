<?php

namespace app\controllers;

class GitController
{
    public function update(): void
    {
        $script_location = realpath(ROOT . '/storage/scripts/update.sh');
        $root = ROOT;
        $command = "sh $script_location $root";
        shell_exec($command);
    }
}