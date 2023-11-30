function toggleForm() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    }
}

function loginForm() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
}

function registerForm() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
}

function validateYear(input) {
    const year = input.value.split('-')[0];
    if (year.length !== 4) {
        alert("Vui lòng nhập đúng 4 chữ số cho năm.");
        input.value = ''; 
    }
}

