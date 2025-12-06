// signup.js — client-side validation for signup form and password match
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('signupForm');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');
    const passwordError = document.getElementById('passwordError');
    const confirmError = document.getElementById('confirmError');

    const toggle = document.getElementById('togglePass');
    toggle && toggle.addEventListener('click', function(){
        if(password.type === 'password'){
            password.type = 'text';
            toggle.textContent = 'Hide';
        } else {
            password.type = 'password';
            toggle.textContent = 'Show';
        }
    });

    form && form.addEventListener('submit', function(e){
        e.preventDefault();
        let valid = true;
        [nameError, emailError, phoneError, passwordError, confirmError].forEach(el => el.textContent = '');

        if(!name.value || name.value.trim().length < 2){
            nameError.textContent = 'Please enter your full name'; valid = false;
        }
        if(!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)){
            emailError.textContent = 'Please enter a valid email'; valid = false;
        }
        if(phone.value && !/^01\d{9}$/.test(phone.value)){
            phoneError.textContent = 'Please enter a valid Bangladeshi phone number (01XXXXXXXXX)'; valid = false;
        }
        if(!password.value || password.value.length < 6){
            passwordError.textContent = 'Password must be at least 6 characters'; valid = false;
        }
        if(password.value !== confirm.value){
            confirmError.textContent = 'Passwords do not match'; valid = false;
        }

        if(!valid) return;

        // Submit the form to the server when client-side validation passes
        const btn = form.querySelector('.btn.primary');
        btn.textContent = 'Creating...';
        btn.disabled = true;
        form.submit();
    });
});