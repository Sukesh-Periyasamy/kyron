/**
 * Contact Form JavaScript
 * Handles form submission and validation for Kyron Healthcare contact form
 * Uses Formspree for secure form handling
 */

$(document).ready(function() {
  
  // Form validation and submission
  $('#contactForm').on('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    var name = $('#name').val().trim();
    var email = $('#email').val().trim();
    var subject = $('#subject').val().trim();
    var message = $('#message').val().trim();
    
    // Basic validation
    if (name === '' || email === '' || subject === '' || message === '') {
      showMessage('Please fill in all fields.', 'error');
      return false;
    }
    
    // Email validation
    if (!isValidEmail(email)) {
      showMessage('Please enter a valid email address.', 'error');
      return false;
    }
    
    // Show loading state
    $('#sendmessage').hide();
    $('#errormessage').hide();
    $('.loading').show();
    
    // Submit form to Formspree
    var formData = new FormData(this);
    
    $.ajax({
      url: 'https://formspree.io/f/xvgpgzjw',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        $('.loading').hide();
        showMessage('Thank you! Your message has been sent successfully. We will get back to you soon.', 'success');
        $('#contactForm')[0].reset();
      },
      error: function(xhr, status, error) {
        $('.loading').hide();
        showMessage('Sorry, there was an error sending your message. Please try again or contact us directly at Info@kyronhealthcare.com', 'error');
      }
    });
    
    return false;
  });
  
  // Email validation function
  function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  // Show message function
  function showMessage(message, type) {
    if (type === 'success') {
      $('#sendmessage').html(message).show();
      $('#errormessage').hide();
    } else {
      $('#errormessage').html(message).show();
      $('#sendmessage').hide();
    }
  }
  
  // Hide messages when user starts typing
  $('#contactForm input, #contactForm textarea').on('input', function() {
    $('#sendmessage').hide();
    $('#errormessage').hide();
  });
  
});
