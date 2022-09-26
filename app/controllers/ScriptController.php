<?php

namespace app\controllers;

class ScriptController
{
    public function git_update(): void
    {
        $this->run_script("git-update", ROOT);
    }

    private function run_script(string $name, ...$params): bool
    {
        $root = ROOT;
        $script_location = realpath("$root/storage/scripts/$name.sh");
        if (!file_exists(realpath($script_location))) return false;

        $params = implode(" ", $params);
        $command = "screen -dm sh $script_location $params";
        echo $command;
        shell_exec($command);
        return true;
    }
}