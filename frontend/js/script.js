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

$(document).on("click", "#btn-create", function () {
  alert("CREATE action (admin only)");
});

$(document).on("click", "#btn-read", function () {
  loadPayments();
});

$(document).on("click", "#btn-update", function () {
  alert("UPDATE action (admin only)");
});

$(document).on("click", "#btn-delete", function () {
  alert("DELETE action (admin only)");
});

// ==================== INIT SERVICES ====================
$(document).ready(function () {
  BookingService.init();
});

// Initialize services on hash change (since spapp doesn't fire custom events)
$(window).on('hashchange', function() {
  setTimeout(function() {
    initServicesForCurrentPage();
  }, 100); // Small delay to ensure page is loaded
});

// Also run on initial load
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