<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\Transaksi;
use App\Models\User;
use App\Policies\CartPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductsPolicy;
use App\Policies\TransaksiPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Transaksi::class => TransaksiPolicy::class,
        Cart::class => CartPolicy::class,
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Products::class => ProductsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
