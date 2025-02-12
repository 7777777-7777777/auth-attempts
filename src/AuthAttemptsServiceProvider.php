<?php

namespace Manzhouya\AuthAttempts;

use Illuminate\Support\ServiceProvider;

class AuthAttemptsServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(AuthAttempts $extension)
    {
        if (! AuthAttempts::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'auth-attempt-limit');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/manzhouya/auth-attempt-limit')],
                'auth-attempt-limit'
            );
        }

        $this->app->booted(function () {
            AuthAttempts::routes(__DIR__.'/../routes/web.php');
        });
    }
}
