 var AuthService = {
  login: function (email, password) {
    RestClient.post(
      "auth/login",
      { email: email, password: password },
      function (response) {
        localStorage.setItem(Constants.TOKEN_KEY, response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data));
        window.location.hash = "#home";
      },
      function () {
        alert("Login failed");
      }
    );
  },

  register: function (email, password) {
    RestClient.post(
      "auth/register",
      { email: email, password: password },
      function () {
        alert("Registration successful. Please log in.");
        window.location.hash = "#login";
      },
      function (xhr) {
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