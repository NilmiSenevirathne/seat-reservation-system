document.addEventListener('DOMContentLoaded', function () {
  // ✅ Show/hide password toggles
  document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const input = this.previousElementSibling;
      if (input.type === "password") {
        input.type = "text";
        this.innerHTML = '<i class="fa fa-eye-slash"></i>';
      } else {
        input.type = "password";
        this.innerHTML = '<i class="fa fa-eye"></i>';
      }
    });
  });

  // ✅ Form validation
  document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const repeat_password = document.getElementById('repeat_password').value;
    let errorMessages = [];

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      errorMessages.push("Please enter a valid email address.");
    }

    const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
    if (!passwordPattern.test(password)) {
      errorMessages.push("Password must be at least 8 characters long and include at least one uppercase letter and one number.");
    }

    if (password !== repeat_password) {
      errorMessages.push("Passwords do not match.");
    }

    if (errorMessages.length > 0) {
      e.preventDefault();
      alert(errorMessages.join("\n"));
    }
  });
});
