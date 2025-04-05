$(document).ready(function() {
    const $sendOtpForm = $('#send-otp-form');
    const $verifyOtpForm = $('#verify-otp-form');
    const $phoneInput = $('#phone');

    // Format phone number
    $phoneInput.on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            value = '+' + value;
        }
        $(this).val(value);
    });

    // Handle send OTP form submission
    $sendOtpForm.on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.error) {
                    alert(response.message);
                } else {
                    $sendOtpForm.hide();
                    $verifyOtpForm.show();
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'An error occurred');
            }
        });
    });

    // Handle verify OTP form submission
    $verifyOtpForm.on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('phone', $phoneInput.val());
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.error) {
                    alert(response.message);
                } else {
                    window.location.href = response.data.next_url;
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'An error occurred');
            }
        });
    });
}); 