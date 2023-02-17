<?php

namespace app\controllers;

class APIController
{
    public function git_pull(): void
    {
        run_script("git-pull");
        clear_cache();
        echo 'done';
    }

    public function dependencies(): void {
        run_script("dependencies", ROOT);
        echo 'done';
    }
}