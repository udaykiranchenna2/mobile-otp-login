<?php

namespace Botble\MobileOtpLogin\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\MobileOtpLogin\Models\MobileOtpLogin;
use Botble\MobileOtpLogin\Repositories\Caches\MobileOtpLoginCacheDecorator;
use Botble\MobileOtpLogin\Repositories\Eloquent\MobileOtpLoginRepository;
use Botble\MobileOtpLogin\Repositories\Interfaces\MobileOtpLoginInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;

class MobileOtpLoginServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MobileOtpLoginInterface::class, function () {
            return new MobileOtpLoginCacheDecorator(new MobileOtpLoginRepository(new MobileOtpLogin));
        });

        $this->app->register(HookServiceProvider::class);
    }

    public function boot()
    {
        $this->setNamespace('plugins/mobile-otp-login')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadMigrations()
            ->loadHelpers()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-mobile-otp-login',
                'priority' => 5,
                'parent_id' => 'cms-core-settings',
                'name' => 'plugins/mobile-otp-login::mobile-otp-login.name',
                'icon' => null,
                'url' => route('mobile-otp-login.settings'),
                'permissions' => ['mobile-otp-login.settings'],
            ]);
        });
    }
} 