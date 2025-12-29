var PaymentService = {

   loadPayments: function (successCallback, errorCallback) {
    $.blockUI({ message: '<h3>Loading payments...</h3>' });
    
    RestClient.get(
      "payments", 
      function(data) {
        $.unblockUI();
        if (successCallback) successCallback(data);
      },
      function(xhr) {
        $.unblockUI();
        if (errorCallback) errorCallback(xhr);
      }
    );
  },

 deletePayment: function (id, callback) {
    $.blockUI({ message: '<h3>Deleting payment...</h3>' });
    
    RestClient.delete(
      "payments/" + id, 
      null, 
      function(response) {
        $.unblockUI();
        alert("Payment deleted successfully");
        if (callback) callback(response);
      },
      function(xhr) {
        $.unblockUI();
        alert("Failed to delete payment");
      }
    );
  }
};