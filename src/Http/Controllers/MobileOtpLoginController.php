<?php

namespace Botble\MobileOtpLogin\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Models\Customer;
use Botble\MobileOtpLogin\Repositories\Interfaces\MobileOtpLoginInterface;
use Botble\Setting\Supports\SettingStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MobileOtpLoginController extends BaseController
{
    protected $mobileOtpLoginRepository;

    public function __construct(MobileOtpLoginInterface $mobileOtpLoginRepository)
    {
        $this->mobileOtpLoginRepository = $mobileOtpLoginRepository;
    }

    public function getSettings()
    {
        page_title()->setTitle(trans('plugins/mobile-otp-login::mobile-otp-login.settings'));

        return view('plugins/mobile-otp-login::settings');
    }

    public function postSettings(Request $request, SettingStore $settingStore, BaseHttpResponse $response)
    {
        $settingStore
            ->set('mobile_otp_login_enabled', $request->input('mobile_otp_login_enabled', false))
            ->set('mobile_otp_login_otp_length', $request->input('mobile_otp_login_otp_length', 6))
            ->set('mobile_otp_login_otp_expiry', $request->input('mobile_otp_login_otp_expiry', 5))
            ->save();

        return $response
            ->setNextUrl(route('mobile-otp-login.settings'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function sendOtp(Request $request, BaseHttpResponse $response)
    {
        if (!setting('mobile_otp_login_enabled', false)) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/mobile-otp-login::mobile-otp-login.disabled'));
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setMessage($validator->errors()->first());
        }

        $phone = $request->input('phone');
        $otp = generate_otp(setting('mobile_otp_login_otp_length', 6));
        $expiresAt = now()->addMinutes(setting('mobile_otp_login_otp_expiry', 5));

        // Store OTP in database
        $this->mobileOtpLoginRepository->createOrUpdate([
            'phone' => $phone,
            'otp' => $otp,
            'is_verified' => false,
            'expires_at' => $expiresAt,
        ], ['phone' => $phone]);

        // TODO: Implement your OTP sending logic here (SMS gateway integration)

        return $response
            ->setMessage(trans('plugins/mobile-otp-login::mobile-otp-login.otp_sent'));
    }

    public function verifyOtp(Request $request, BaseHttpResponse $response)
    {
        if (!setting('mobile_otp_login_enabled', false)) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/mobile-otp-login::mobile-otp-login.disabled'));
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
            'otp' => 'required|string|size:' . setting('mobile_otp_login_otp_length', 6),
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setMessage($validator->errors()->first());
        }

        $phone = $request->input('phone');
        $otp = $request->input('otp');

        $otpRecord = $this->mobileOtpLoginRepository->findByPhone($phone);

        if (!$otpRecord || $otpRecord->otp !== $otp || $otpRecord->expires_at->isPast()) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/mobile-otp-login::mobile-otp-login.invalid_otp'));
        }

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => 'Customer',
                'password' => Hash::make(Str::random(32)),
            ]
        );

        // Login the customer
        auth('customer')->login($customer);

        // Mark OTP as verified
        $otpRecord->is_verified = true;
        $otpRecord->save();

        return $response
            ->setNextUrl(route('customer.overview'))
            ->setMessage(trans('plugins/mobile-otp-login::mobile-otp-login.login_success'));
    }
} 