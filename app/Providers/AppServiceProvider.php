<?php

namespace App\Providers;

use App\Models\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Schema::defaultStringLength(191);

        // User::created(function($user){ 
        //     if ($user->verification_token) {
        //         Mail::to($user->email)->send(new UserCreated($user));
        //     } 
        // });

        User::updated(function($user){ 
            // if ($user->isDirty('verification_token') && !empty($user->verification_token)) {
            //     \Log::info(print_r(date('H:i:s') . ' inicio.', true)); 
            //     Mail::to($user->email)->send(new UserCreated($user));
            //     \Log::info(print_r(date('H:i:s') . ' fin ' . $user->email, true));  
            // } 
        });

        User::updated(function($user){ 
            if ($user->isDirty('email')) {
                Mail::to($user->email)->send(new UserMailChanged($user));
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
