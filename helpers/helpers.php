<?php

if (!function_exists('generate_otp')) {
    function generate_otp($length = 6)
    {
        return strtoupper(substr(md5(uniqid()), 0, $length));
    }
}

if (!function_exists('is_mobile_otp_login_enabled')) {
    function is_mobile_otp_login_enabled()
    {
        return setting('mobile_otp_login_enabled', false);
    }
}

if (!function_exists('get_otp_expiry_time')) {
    function get_otp_expiry_time()
    {
        return setting('mobile_otp_login_otp_expiry', 5);
    }
} 