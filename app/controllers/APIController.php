<?php

namespace app\controllers;

class APIController
{
    public function git_pull(): void
    {
        run_script("git-pull", ROOT);
    }
}