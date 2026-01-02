<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nightwatch\Facades\Nightwatch;
use Lorisleiva\Actions\Facades\Actions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('admin', fn () => auth()->user()?->role === UserRole::Administrator);

        if ($this->app->runningInConsole()) {
            Actions::registerCommands();
        }

        // Allow admins to perform all actions
        Gate::before(
            fn (User $user) => $user->role === UserRole::Administrator ? true : null
        );

        // Configure nightwatch
        Event::listen(function (CommandStarting $event) {
            if (in_array($event->command, [
                'horizon:status',
                'horizon:snapshot',
            ])) {
                Nightwatch::dontSample();
            }
        });
    }
}
