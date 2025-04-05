<?php

namespace Botble\MobileOtpLogin\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(RouteMatched::class, function (): void {
            add_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, [$this, 'addOtpLoginOptions'], 25, 2);
        });
    }

    public function addOtpLoginOptions(?string $html, string $module): ?string
    {
        if (!setting('mobile_otp_login_enabled', false) || $module !== 'customer') {
            return $html;
        }

        // Add CSS
        Theme::asset()
            ->usePath(false)
            ->add(
                'mobile-otp-login-css',
                asset('vendor/core/plugins/mobile-otp-login/css/mobile-otp-login.css'),
                [],
                [],
                '1.0.0'
            );

        // Add JavaScript
        Theme::asset()
            ->container('footer')
            ->usePath(false)
            ->add(
                'mobile-otp-login-js',
                asset('vendor/core/plugins/mobile-otp-login/js/mobile-otp-login.js'),
                ['jquery'],
                [],
                '1.0.0'
            );

        return $html . view('plugins/mobile-otp-login::login-options')->render();
    }
} 