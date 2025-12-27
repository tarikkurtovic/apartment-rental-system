var BookingService = {

   init: function () {
    BookingService.initBookingPopup();
  },


  initDatepickers: function () {
  $('#datepicker').datepicker({
    iconsLibrary: 'fontawesome',
    icons: {
      rightIcon: '<span class="fa fa-caret-down"></span>'
    },
    format: 'yyyy-mm-dd'
  });

  $('#datepicker2').datepicker({
    iconsLibrary: 'fontawesome',
    icons: {
      rightIcon: '<span class="fa fa-caret-down"></span>'
    },
    format: 'yyyy-mm-dd'
  });
},


  initBookingPopup: function () {
  $('.popup-with-form').magnificPopup({
    type: 'inline',
    preloader: false,
    focus: false,
    callbacks: {
      open: function () {
        BookingService.initDatepickers();
        BookingService.initBookingValidation();
      }
    }
  });
},

  initBookingValidation: function () {
    if ($("#test-form").data('validator')) {
    $("#test-form").validate().destroy();
  }
    $("#test-form").validate({
      rules: {
        check_in: {
          required: true
        },
        check_out: {
          required: true
        },
        adults: {
          required: true
        },
        room_type: {
          required: true
        }
      },
      messages: {
        check_in: "Please select check-in date",
        check_out: "Please select check-out date",
        adults: "Please select number of adults",
        room_type: "Please select room type"
      },
      submitHandler: function(form) {
          $.magnificPopup.close();
          window.location.hash = '#home';
      }
    });
  },

 checkAvailability: function (checkData, successCallback, errorCallback) {
    $.blockUI({ message: '<h3>Checking availability...</h3>' });
    
    RestClient.post(
      "bookings/check-availability", 
      checkData, 
      function(response) {
        $.unblockUI();
        alert("Rooms available!");
        $.magnificPopup.close();
        if (successCallback) successCallback(response);
      },
      function(xhr) {
        $.unblockUI();
        alert(xhr.responseText || "Failed to check availability");
        if (errorCallback) errorCallback(xhr);
      }
    );
  },

  createBooking: function (bookingData, successCallback, errorCallback) {
    $.blockUI({ message: '<h3>Creating booking...</h3>' });
    
    RestClient.post(
      "bookings", 
      bookingData, 
      function(response) {
        $.unblockUI();
        alert("Booking created successfully!");
        if (successCallback) successCallback(response);
      },
      function(xhr) {
        $.unblockUI();
        alert(xhr.responseText || "Failed to create booking");
        if (errorCallback) errorCallback(xhr);
      }
    );
  }
};
