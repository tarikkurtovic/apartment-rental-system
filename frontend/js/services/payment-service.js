var PaymentService = {

  loadPayments: function () {
    RestClient.get("payments", function (data) {

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
                onclick="PaymentService.deletePayment(${p.id})">
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

    }, function () {
      window.location.hash = "#login";
    });
  },

  deletePayment: function (id) {
    RestClient.delete("payments/" + id, null, function () {
      PaymentService.loadPayments();
    });
  }
};
