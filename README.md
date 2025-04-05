# Mobile OTP Login Plugin for Shofy eCommerce

This plugin adds mobile OTP (One-Time Password) login functionality to Shofy eCommerce platform.

## Features

- Mobile number based authentication
- Configurable OTP length and expiry time
- Admin settings panel
- Automatic customer creation
- Session-based OTP storage

## Installation

1. Copy the plugin folder to `platform/plugins/mobile-otp-login`
2. Go to Admin Panel -> Plugins
3. Find "Mobile OTP Login" and click Activate
4. Run the database migrations:
   ```bash
   php artisan migrate
   ```

## Configuration

1. Go to Admin Panel -> Mobile OTP Login Settings
2. Enable/Disable the plugin
3. Configure OTP length and expiry time
4. Save settings

## Usage

### For Customers

1. Enter mobile number on login page
2. Receive OTP via SMS
3. Enter OTP to login
4. If account doesn't exist, it will be created automatically

### For Developers

#### Helper Functions

```php
// Generate OTP
$otp = generate_otp($length);

// Check if OTP login is enabled
$enabled = is_mobile_otp_login_enabled();

// Get OTP expiry time
$expiry = get_otp_expiry_time();
```

## Requirements

- PHP >= 8.0
- Laravel >= 9.0
- Botble CMS >= 6.0
- Shofy eCommerce

## Support

For support, please contact the plugin author. 