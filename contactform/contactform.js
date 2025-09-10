/**
 * Contact Form JavaScript
 * Handles form validation for Kyron Healthcare contact form
 * Uses PHP backend for secure form processing
 */

$(document).ready(function() {
  
  // Form validation before submission
  $('#contactForm').on('submit', function(e) {
    // Clear previous messages
    $('#sendmessage').hide();
    $('#errormessage').hide();
    
    // Get form data
    var name = $('#name').val().trim();
    var email = $('#email').val().trim();
    var subject = $('#subject').val().trim();
    var message = $('#message').val().trim();
    
    // Basic validation
    var errors = [];
    
    if (name === '' || name.length < 4) {
      errors.push('Name must be at least 4 characters long.');
    }
    
    if (email === '') {
      errors.push('Email is required.');
    } else if (!isValidEmail(email)) {
      errors.push('Please enter a valid email address.');
    }
    
    if (subject === '' || subject.length < 4) {
      errors.push('Subject must be at least 4 characters long.');
    }
    
    if (message === '') {
      errors.push('Message is required.');
    }
    
    // If there are errors, prevent submission and show them
    if (errors.length > 0) {
      e.preventDefault();
      showMessage(errors.join('<br>'), 'error');
      return false;
    }
    
    // If validation passes, show loading state and allow form submission
    $('.loading').show();
    $('#contactForm button[type="submit"]').prop('disabled', true).text('Sending...');
    
    // Form will submit normally to PHP handler
    return true;
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
    
    // Scroll to message
    $('html, body').animate({
      scrollTop: $('#errormessage, #sendmessage').offset().top - 100
    }, 500);
  }
  
  // Hide messages when user starts typing
  $('#contactForm input, #contactForm textarea').on('input', function() {
    $('#sendmessage').hide();
    $('#errormessage').hide();
    // Re-enable submit button if it was disabled
    $('#contactForm button[type="submit"]').prop('disabled', false).text('Send Message');
    $('.loading').hide();
  });
  
  // Add required attributes for HTML5 validation as backup
  $('#name').attr('required', true);
  $('#email').attr('required', true);
  $('#subject').attr('required', true);
  $('#message').attr('required', true);
  
});
