<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage())
                ->subject('آدرس ایمیل خود را تایید کنید')
                ->line('لطفا روی دکمه زیر کلیک کنید تا آدرس ایمیل خود را تأیید کنید.')
                ->action('تایید آدرس ایمیل', $url)
                ->line('اگر حساب کاربری ایجاد نکردید، هیچ اقدام دیگری لازم نیست.');
     });
    }
}
