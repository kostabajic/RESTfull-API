<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\AdminAction;

class ProductPolicy
{
    use HandlesAuthorization,AdminAction;

    /**
     * Determine whether the user can update the product.
     *
     * @param \App\User    $user
     * @param \App\Product $product
     *
     * @return mixed
     */
    public function addCategory(User $user, Product $product)
    {
        return $user->id === $product->seller->id;
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param \App\User    $user
     * @param \App\Product $product
     *
     * @return mixed
     */
    public function deleteCategory(User $user, Product $product)
    {
        return $user->id === $product->seller->id;
    }
}
