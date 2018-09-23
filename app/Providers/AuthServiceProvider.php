<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Carbon;
use App\Policies\BuyerPolicy;
use App\Policies\UserPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TrasactionPolicy;
use App\Buyer;
use App\Seller;
use App\User;
use App\Product;
use App\Policies\ProductPolicy;
use Illuminate\Auth\Access\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TrasactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('admin-actions', function ($user) {
            return $user->isAdmin();
        });
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-produts' => 'Cretae new transactions for the specific product',
            'manage-products' => 'Can create, reade, update and delete (CRUD) products',
            'manage-account' => "Reade your acount data. Modifly your account but can't delete.",
            'read-general' => 'Reade general informations like your transactions, products etc.',
        ]);
    }
}
