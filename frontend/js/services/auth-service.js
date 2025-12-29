 var AuthService = {

    init: function () {
    AuthService.initLoginValidation();
    AuthService.initRegisterValidation();
  },

  initLoginValidation: function () {
    $("#login-form").validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
          minlength: 6
        }
      },
      messages: {
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please enter your password",
          minlength: "Password must be at least 6 characters"
        }
      },
      submitHandler: function(form) {
        const email = $("#login-email").val();
        const password = $("#login-password").val();
        
        AuthService.login(email, password);
        return false;
      }
    });
  },

  initRegisterValidation: function () {
    $("#register-form").validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
          minlength: 8,
          maxlength: 20
        },
        password_repeat: {
          required: true,
          equalTo: "#register-password"
        }
      },
      messages: {
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please enter a password",
          minlength: "Password must be at least 8 characters",
          maxlength: "Password cannot exceed 20 characters"
        },
        password_repeat: {
          required: "Please repeat your password",
          equalTo: "Passwords do not match"
        }
      },
      submitHandler: function(form) {
        const email = $("#register-email").val();
        const password = $("#register-password").val();
        
        AuthService.register(email, password);
        return false;
      }
    });
  },

  login: function (email, password) {
    $.blockUI({ message: '<h3>Logging in...</h3>' });

    RestClient.post(
      "/auth/login",
      { email: email, password: password },
      function (response) {
        $.unblockUI();
        localStorage.setItem(Constants.TOKEN_KEY, response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data));
        
        // Update admin link visibility
        if (Utils.isAdmin()) {
          $('#admin-link').show();
        }
        
        // Clear any query params from URL and navigate to home
        window.history.replaceState({}, document.title, window.location.pathname + '#home');
        window.location.hash = '#home';
      },
      function () {
        $.unblockUI();
        alert("Login failed");
      }
    );
  },

  register: function (email, password) {
    $.blockUI({ message: '<h3>Registering...</h3>' });

    RestClient.post(
      "/auth/register",
      { email: email, password: password },
      function () {
        $.unblockUI();
        alert("Registration successful. Please log in.");
        window.location.hash = "#login";
      },
      function (xhr) {
        $.unblockUI();
        alert(xhr.responseText || "Registration failed");
      }
    );
  },

  logout: function () {
    localStorage.removeItem(Constants.TOKEN_KEY);
    localStorage.removeItem("user");
    window.location.hash = "#login";
  }
};