<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

use App\Models\Address;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Jetstream::inertia()->whenRendering(
            'Profile/Show',
            function (Request $request, array $data) {
                return array_merge($data, [
                    'addresses'=>Address::orderBy('updated_at', 'DESC')->where('user_id', Auth::id())->get(),
                    'countries'=>config('countries')
                ]);
            }
        );
    }
}
