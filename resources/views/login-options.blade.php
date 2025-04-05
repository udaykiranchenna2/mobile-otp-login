<div class="mobile-otp-login-options">
    <div class="or-divider">
        <span>{{ __('Or login with') }}</span>
    </div>

    <div class="otp-login-form">
        <form action="{{ route('customer.send-otp') }}" method="POST" id="send-otp-form">
            @csrf
            <div class="form-group">
                <label for="phone">{{ __('Phone Number') }}</label>
                <input type="tel" name="phone" id="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Send OTP') }}</button>
        </form>

        <form action="{{ route('customer.verify-otp') }}" method="POST" id="verify-otp-form" style="display: none;">
            @csrf
            <div class="form-group">
                <label for="otp">{{ __('Enter OTP') }}</label>
                <input type="text" name="otp" id="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Verify OTP') }}</button>
        </form>
    </div>
</div> 