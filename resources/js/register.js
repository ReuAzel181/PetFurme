function handleRegistration(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    const emailInput = form.querySelector('input[name="email"]');
    const emailFeedback = emailInput.nextElementSibling;
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Processing...';

    // Check if email exists when form is submitted
    fetch(`/check-email?email=${encodeURIComponent(emailInput.value)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            emailInput.classList.add('is-invalid');
            emailFeedback.textContent = 'This email is already taken. Please use a different email or login instead.';
            emailFeedback.style.display = 'block';
            submitButton.disabled = false;
            submitButton.innerHTML = 'Create Account';
            return Promise.reject('Email exists');
        }
        
        // If email doesn't exist, continue with registration
        return fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.verify_otp) {
                // Show OTP verification form
                showOTPForm();
                alert('Please check your email for the verification code.');
            }
        } else {
            // Show validation errors
            showErrors(data.errors);
        }
    })
    .catch(error => {
        if (error === 'Email exists') return;
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    })
    .finally(() => {
        if (!emailInput.classList.contains('is-invalid')) {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Create Account';
        }
    });
} 