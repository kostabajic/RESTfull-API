<?php

namespace App\Traits;

trait AdminAction
{
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
