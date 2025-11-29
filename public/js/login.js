// login.js — simple client-side validation and password toggle
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
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
        emailError.textContent = '';
        passwordError.textContent = '';

        if(!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)){
            emailError.textContent = 'Please enter a valid email address';
            valid = false;
        }
        if(!password.value || password.value.length < 6){
            passwordError.textContent = 'Password must be at least 6 characters';
            valid = false;
        }

        if(!valid){
            return;
        }

        // For now just show a success state — backend integration later
        form.querySelector('.btn.primary').textContent = 'Signing...';
        form.querySelector('.btn.primary').disabled = true;
        setTimeout(()=>{
            form.querySelector('.btn.primary').textContent = 'Signed in';
            form.querySelector('.btn.primary').disabled = false;
        }, 900);
    });
});