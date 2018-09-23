<?php

namespace App\Policies;

use App\User;
use App\Seller;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\AdminAction;

class SellerPolicy
{
    use HandlesAuthorization,AdminAction;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the seller.
     *
     * @param \App\User   $user
     * @param \App\Seller $seller
     *
     * @return mixed
     */
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can update the seller.
     *
     * @param \App\User   $user
     * @param \App\Seller $seller
     *
     * @return mixed
     */
    public function sale(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can delete the seller.
     *
     * @param \App\User   $user
     * @param \App\Seller $seller
     *
     * @return mixed
     */
    public function editProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can restore the seller.
     *
     * @param \App\User   $user
     * @param \App\Seller $seller
     *
     * @return mixed
     */
    public function deleteProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }
}
