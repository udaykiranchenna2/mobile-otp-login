@extends('core/base::forms.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mobile OTP Login Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('mobile-otp-login.settings.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="mobile_otp_login_enabled">Enable Mobile OTP Login</label>
                            <select name="mobile_otp_login_enabled" id="mobile_otp_login_enabled" class="form-control">
                                <option value="1" {{ setting('mobile_otp_login_enabled', false) ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !setting('mobile_otp_login_enabled', false) ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mobile_otp_login_otp_length">OTP Length</label>
                            <input type="number" name="mobile_otp_login_otp_length" id="mobile_otp_login_otp_length" 
                                class="form-control" value="{{ setting('mobile_otp_login_otp_length', 6) }}" min="4" max="8">
                        </div>

                        <div class="form-group">
                            <label for="mobile_otp_login_otp_expiry">OTP Expiry (minutes)</label>
                            <input type="number" name="mobile_otp_login_otp_expiry" id="mobile_otp_login_otp_expiry" 
                                class="form-control" value="{{ setting('mobile_otp_login_otp_expiry', 5) }}" min="1" max="30">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 