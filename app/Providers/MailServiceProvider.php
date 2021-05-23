<?php

namespace App\Providers;

use App\Interfaces\Mailer;
use App\Util\LaravelMailer;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     *
     *
     * @return void
     */
    public function register() {
        $this->app->bind(Mailer::class, function () {
            return new LaravelMailer();
        });
    }
}
