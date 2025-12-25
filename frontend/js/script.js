$(function () {
  if (!location.hash) location.hash = '#home';

  var app = $.spapp({
    defaultView: '#home',
    templateDir: './views/'   
  });
  app.run();



  
  function setActive() {
    var view = location.hash || '#home';
    $('#navigation a').removeClass('active');
    $('#navigation a[href="' + view + '"]').addClass('active');
  }
  setActive();
  $(window).on('hashchange', setActive);
});

$(document).on("click", "#login-btn", function () {
  const email = $("#login-email").val();
  const password = $("#login-password").val();

  if (!email || !password) {
    alert("Please enter email and password");
    return;
  }

  AuthService.login(email, password);
});





$(document).on("click", "#register-btn", function () {

  const email = $("#register-email").val();
  const password = $("#register-password").val();
  const repeat = $("#register-password-repeat").val();

  if (!email || !password || !repeat) {
    alert("All fields are required");
    return;
  }

  if (password !== repeat) {
    alert("Passwords do not match");
    return;
  }

  AuthService.register(email, password);
});





$(window).on('load hashchange', function () {

  if (location.hash === '#admin-panel') {

    if (!Utils.isLoggedIn()) {
      location.hash = '#login';
      return;
    }

    if (!Utils.isAdmin()) {
      alert('Access denied');
      location.hash = '#home';
      return;
    }
  }

  if (Utils.isAdmin()) {
    $('#admin-link').show();
  } else {
    $('#admin-link').hide();
  }
});



$(document).on("click", "#btn-create", function () {
  alert("CREATE action (admin only)");
});

$(document).on("click", "#btn-read", function () {
  alert("READ action (admin only)");
});

$(document).on("click", "#btn-update", function () {
  alert("UPDATE action (admin only)");
});

$(document).on("click", "#btn-delete", function () {
  alert("DELETE action (admin only)");
});