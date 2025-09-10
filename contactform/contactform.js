/**
 * Contact Form JavaScript
 * Handles form submission and validation for Kyron Healthcare contact form
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
    
    // Simulate form submission (since we're using mailto)
    setTimeout(function() {
      $('.loading').hide();
      showMessage('Thank you! Your message has been sent. We will get back to you soon.', 'success');
      
      // Create mailto link and open it
      var mailtoLink = 'mailto:Info@kyronhealthcare.com' +
        '?subject=' + encodeURIComponent(subject) +
        '&body=' + encodeURIComponent('Name: ' + name + '\nEmail: ' + email + '\n\nMessage:\n' + message);
      
      window.location.href = mailtoLink;
      
      // Reset form
      $('#contactForm')[0].reset();
    }, 1000);
    
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
