<?php

namespace App\Policies;

use App\User;
use App\Trasaction;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\AdminAction;

class TrasactionPolicy
{
    use HandlesAuthorization,AdminAction;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the trasaction.
     *
     * @param \App\User       $user
     * @param \App\Trasaction $trasaction
     *
     * @return mixed
     */
    public function view(User $user, Trasaction $trasaction)
    {
    }
}
