<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share the $customer data with the views that need it
        View::composer('frontend.profile.account-sidebar', function ($view) {
            // Get the currently authenticated user
            $auth = Auth::user();

            // If the user is authenticated, fetch the corresponding customer data
            if ($auth) {
                $customer = Customer::where('user_id', $auth->id)->first();
                $view->with('customer', $customer);  // Share the customer data with all views
            } else {
                $view->with('customer', null);  // If no user is logged in, pass null
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
