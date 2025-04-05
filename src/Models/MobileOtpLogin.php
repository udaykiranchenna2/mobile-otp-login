<?php

namespace Botble\MobileOtpLogin\Models;

use Botble\Base\Models\BaseModel;

class MobileOtpLogin extends BaseModel
{
    protected $table = 'mobile_otp_logins';

    protected $fillable = [
        'phone',
        'otp',
        'is_verified',
        'expires_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
    ];
} 