/**
 * Main JavaScript file for Kyron Healthcare website
 * Contains general site functionality and interactions
 */

$(document).ready(function () {

  // Smooth scrolling for anchor links
  $('a[href^="#"]').on('click', function (event) {
    var target = $(this.getAttribute('href'));
    if (target.length) {
      event.preventDefault();
      $('html, body').stop().animate({
        scrollTop: target.offset().top - 70
      }, 1000);
    }
  });

  // Header scroll effect
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });

  $('.back-to-top').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
    return false;
  });

  // Initialize tooltips if Bootstrap is available
  if (typeof $().tooltip === 'function') {
    $('[data-toggle="tooltip"]').tooltip();
  }

  // Initialize popovers if Bootstrap is available
  if (typeof $().popover === 'function') {
    $('[data-toggle="popover"]').popover();
  }

  // Add loading animation to external links
  $('a[href^="http"]:not([href*="' + window.location.hostname + '"])').on('click', function () {
    $(this).append(' <i class="fa fa-spinner fa-spin"></i>');
  });

  // Form animations
  $('.form-control').on('focus', function () {
    $(this).closest('.form-group').addClass('focused');
  });

  $('.form-control').on('blur', function () {
    if ($(this).val() === '') {
      $(this).closest('.form-group').removeClass('focused');
    }
  });

  // Preloader
  $(window).on('load', function () {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function () {
        $(this).remove();
      });
    }
  });

  console.log('Kyron Healthcare - Main JavaScript loaded successfully');

});
