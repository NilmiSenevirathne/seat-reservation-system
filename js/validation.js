// ===== Show/Hide Password =====
document.querySelectorAll('.toggle-password').forEach(toggle => {
  toggle.addEventListener('click', function () {
    const input = this.previousElementSibling;
    const icon = this.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });
});

// ===== Register Form Validation =====
const registerForm = document.querySelector('form[action="register.php"], form:has(button[name="register"])');
if (registerForm) {
  registerForm.addEventListener('submit', function (e) {
    const name = registerForm.querySelector('input[name="name"]');
    const email = registerForm.querySelector('input[name="email"]');
    const password = registerForm.querySelector('input[name="password"]');
    const repeatPassword = registerForm.querySelector('input[name="repeat_password"]');

    if (name && name.value.trim() === '') {
      alert('Please enter your name.');
      name.focus();
      e.preventDefault();
      return false;
    }

    if (email && !/^\S+@\S+\.\S+$/.test(email.value.trim())) {
      alert('Please enter a valid email address.');
      email.focus();
      e.preventDefault();
      return false;
    }

    if (password && password.value.trim().length < 6) {
      alert('Password must be at least 6 characters long.');
      password.focus();
      e.preventDefault();
      return false;
    }

    if (repeatPassword && password && password.value !== repeatPassword.value) {
      alert('Passwords do not match.');
      repeatPassword.focus();
      e.preventDefault();
      return false;
    }
  });
}

// ===== Login Form Validation =====
const loginForm = document.querySelector('form[action="login.php"], form:has(button[name="login"])');
if (loginForm) {
  loginForm.addEventListener('submit', function (e) {
    const email = loginForm.querySelector('input[name="email"]');
    const password = loginForm.querySelector('input[name="password"]');

    if (email && !/^\S+@\S+\.\S+$/.test(email.value.trim())) {
      alert('Please enter a valid email address.');
      email.focus();
      e.preventDefault();
      return false;
    }

    if (password && password.value.trim() === '') {
      alert('Please enter your password.');
      password.focus();
      e.preventDefault();
      return false;
    }
  });
}
