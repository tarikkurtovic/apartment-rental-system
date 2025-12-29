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

// ==================== PAYMENTS ====================
function loadPayments() {
  PaymentService.loadPayments(
    function (data) {
      let html = "";
      data.forEach(p => {
        html += `
          <tr>
            <td>${p.id}</td>
            <td>${p.reservation_id}</td>
            <td>${p.amount}</td>
            <td>${p.currency}</td>
            <td>${p.paid_at}</td>
            <td class="admin-actions">
              <button class="btn btn-danger btn-sm"
                onclick="deletePayment(${p.id})">
                Delete
              </button>
            </td>
          </tr>
        `;
      });

      $("#payments-body").html(html);

      if (!Utils.isAdmin()) {
        $(".admin-actions").hide();
      }
    },
    function () {
      window.location.hash = "#login";
    }
  );
}

function deletePayment(id) {
  if (!confirm("Are you sure you want to delete this payment?")) {
    return;
  }
  PaymentService.deletePayment(id, function () {
    loadPayments();
  });
}

// ==================== ADMIN PANEL ====================
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

// ==================== ADMIN PANEL TAB SWITCHING ====================
var currentAdminTab = 'users';

// ==================== USERS CRUD ====================
function loadUsers() {
  $.blockUI({ message: '<h3>Loading users...</h3>' });
  
  RestClient.get(
    "/users",
    function(data) {
      $.unblockUI();
      let html = "";
      data.forEach(function(user) {
        html += '<tr>' +
          '<td>' + user.id + '</td>' +
          '<td>' + user.name + '</td>' +
          '<td>' + user.email + '</td>' +
          '<td>' + (user.phone || '-') + '</td>' +
          '<td>' + user.role + '</td>' +
          '<td>' +
            '<button class="btn btn-warning btn-sm me-1" onclick="editUser(' + user.id + ')">Edit</button>' +
            '<button class="btn btn-danger btn-sm" onclick="deleteUser(' + user.id + ')">Delete</button>' +
          '</td>' +
        '</tr>';
      });
      $("#users-body").html(html);
    },
    function(xhr) {
      $.unblockUI();
      alert("Failed to load users");
    }
  );
}

function showUserForm(title) {
  $('#user-form-title').text(title);
  $('#user-form-section').show();
  $('html, body').animate({
    scrollTop: $('#user-form-section').offset().top
  }, 300);
}

function hideUserForm() {
  $('#user-form-section').hide();
  $('#user-id').val('');
  $('#user-name').val('');
  $('#user-email').val('');
  $('#user-password').val('');
  $('#user-phone').val('');
  $('#user-role').val('user');
}

function editUser(id) {
  $.blockUI({ message: '<h3>Loading user...</h3>' });
  
  RestClient.get(
    "/users/" + id,
    function(user) {
      $.unblockUI();
      $('#user-id').val(user.id);
      $('#user-name').val(user.name);
      $('#user-email').val(user.email);
      $('#user-password').val('');
      $('#user-phone').val(user.phone || '');
      $('#user-role').val(user.role);
      showUserForm('Edit User');
    },
    function(xhr) {
      $.unblockUI();
      alert("Failed to load user");
    }
  );
}

function deleteUser(id) {
  if (!confirm("Are you sure you want to delete this user?")) {
    return;
  }
  
  $.blockUI({ message: '<h3>Deleting user...</h3>' });
  
  RestClient.delete(
    "/users/" + id,
    null,
    function() {
      $.unblockUI();
      alert("User deleted successfully");
      loadUsers();
    },
    function(xhr) {
      $.unblockUI();
      alert("Failed to delete user");
    }
  );
}

function saveUser() {
  var id = $('#user-id').val();
  var userData = {
    name: $('#user-name').val(),
    email: $('#user-email').val(),
    phone: $('#user-phone').val(),
    role: $('#user-role').val()
  };
  
  var password = $('#user-password').val();
  if (password) {
    userData.password = password;
  }
  
  $.blockUI({ message: '<h3>Saving user...</h3>' });
  
  if (id) {
    // Update existing user
    RestClient.put(
      "/users/" + id,
      userData,
      function() {
        $.unblockUI();
        hideUserForm();
        alert("User updated successfully");
        loadUsers();
      },
      function(xhr) {
        $.unblockUI();
        alert("Failed to update user");
      }
    );
  } else {
    // Create new user
    if (!password) {
      $.unblockUI();
      alert("Password is required for new users");
      return;
    }
    RestClient.post(
      "/users",
      userData,
      function() {
        $.unblockUI();
        hideUserForm();
        alert("User created successfully");
        loadUsers();
      },
      function(xhr) {
        $.unblockUI();
        alert("Failed to create user");
      }
    );
  }
}

// ==================== ADMIN BUTTON HANDLERS ====================
$(document).on("click", "#btn-create", function () {
  hideUserForm();
  showUserForm('Create User');
});

$(document).on("click", "#btn-read", function () {
  loadUsers();
});

$(document).on("click", "#save-user-btn", function() {
  saveUser();
});

$(document).on("click", "#cancel-user-btn", function() {
  hideUserForm();
});

// Load users when admin panel is opened
$(window).on('hashchange', function() {
  if (location.hash === '#admin-panel' && Utils.isAdmin()) {
    setTimeout(loadUsers, 200);
  }
});

// ==================== INIT SERVICES ====================
$(document).ready(function () {
  BookingService.init();
});

$(window).on('hashchange', function() {
  setTimeout(function() {
    initServicesForCurrentPage();
  }, 100); 
});

$(document).ready(function() {
  setTimeout(function() {
    initServicesForCurrentPage();
  }, 300);
});

function initServicesForCurrentPage() {
  if (location.hash === '#login' || location.hash === '#register') {
    AuthService.init();
  } else if (location.hash === '#contact') {
    ContactService.init();
  } else if (location.hash === '#home') {
    BookingService.init();
  }
}