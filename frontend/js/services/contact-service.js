var ContactService = {

  init: function () {
    ContactService.initContactValidation();
  },

   initContactValidation: function () {
    $("#contact-form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2
        },
        email: {
          required: true,
          email: true
        },
        subject: {
          required: true,
          minlength: 5
        },
        message: {
          required: true,
          minlength: 10
        }
      },
      messages: {
        name: {
          required: "Please enter your name",
          minlength: "Name must be at least 2 characters"
        },
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },
        subject: {
          required: "Please enter a subject",
          minlength: "Subject must be at least 5 characters"
        },
        message: {
          required: "Please enter your message",
          minlength: "Message must be at least 10 characters"
        }
      },
      submitHandler: function(form) {
        var contactData = Object.fromEntries(new FormData(form).entries());
        ContactService.sendMessage(contactData);
        form.reset();
      }
    });
  },
  
  sendMessage: function (contactData) {
    $.blockUI({ message: '<h3>Sending message...</h3>' });
    
    RestClient.post(
      "contact", 
      contactData, 
      function(response) {
        $.unblockUI();
        alert("Message sent successfully!");
      },
      function(xhr) {
        $.unblockUI();
        alert(xhr.responseText || "Failed to send message");
      }
    );
  }
};