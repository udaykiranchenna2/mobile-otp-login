<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\MobileOtpLogin\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix()], function () {
        Route::group(['prefix' => 'mobile-otp-login', 'as' => 'mobile-otp-login.'], function () {
            Route::get('settings', [
                'as' => 'settings',
                'uses' => 'MobileOtpLoginController@getSettings',
                'permission' => 'mobile-otp-login.settings',
            ]);

            Route::post('settings', [
                'as' => 'settings.post',
                'uses' => 'MobileOtpLoginController@postSettings',
                'permission' => 'mobile-otp-login.settings',
            ]);
        });
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('send-otp', [
            'as' => 'customer.send-otp',
            'uses' => 'MobileOtpLoginController@sendOtp',
        ]);

        Route::post('verify-otp', [
            'as' => 'customer.verify-otp',
            'uses' => 'MobileOtpLoginController@verifyOtp',
        ]);
    });
}); 