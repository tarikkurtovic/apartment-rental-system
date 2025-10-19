(function () {
  function validatePasswordsMatch(pwdInput, confirmInput) {
    if (!pwdInput || !confirmInput) return;
    confirmInput.setCustomValidity(
      pwdInput.value && confirmInput.value && pwdInput.value !== confirmInput.value
        ? 'Passwords do not match'
        : ''
    );
  }

  document.addEventListener('input', function (e) {
    if (e.target.id === 'password' || e.target.id === 'confirmPassword') {
      const form = e.target.closest('form');
      const pwd = form?.querySelector('#password');
      const confirm = form?.querySelector('#confirmPassword');
      validatePasswordsMatch(pwd, confirm);
    }
  });

  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (form?.id !== 'contactForm') return;
    e.preventDefault(); 
    const pwd = form.querySelector('#password');
    const confirm = form.querySelector('#confirmPassword');
    validatePasswordsMatch(pwd, confirm);

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    form.reset();
    location.hash = '#home';
  });
})();
