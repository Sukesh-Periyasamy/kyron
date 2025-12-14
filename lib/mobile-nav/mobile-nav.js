/**
 * Mobile Navigation System
 * Handles mobile menu toggle and interactions
 */

(function($) {
  'use strict';

  $(document).ready(function() {
    // Mobile nav toggle
    $('.mobile-nav-toggle').on('click', function(e) {
      e.preventDefault();
      $('body').toggleClass('mobile-nav-active');
      
      // Toggle aria-expanded
      var expanded = $('body').hasClass('mobile-nav-active');
      $(this).attr('aria-expanded', expanded);
    });

    // Close mobile nav when clicking overlay
    $('.mobile-nav-overlay').on('click', function() {
      $('body').removeClass('mobile-nav-active');
      $('.mobile-nav-toggle').attr('aria-expanded', 'false');
    });

    // Close mobile nav when clicking close button
    $('.mobile-nav-close').on('click', function() {
      $('body').removeClass('mobile-nav-active');
      $('.mobile-nav-toggle').attr('aria-expanded', 'false');
    });

    // Handle dropdown menus in mobile nav
    $('.mobile-nav .drop-down > a').on('click', function(e) {
      e.preventDefault();
      var $parent = $(this).parent();
      
      // Close other dropdowns
      $('.mobile-nav .drop-down').not($parent).removeClass('active').find('ul').slideUp(300);
      
      // Toggle current dropdown
      $parent.toggleClass('active');
      $parent.find('> ul').slideToggle(300);
    });

    // Close mobile nav when clicking a link (but not dropdown parent)
    $('.mobile-nav a:not(.drop-down > a)').on('click', function() {
      if ($(window).width() < 992) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle').attr('aria-expanded', 'false');
      }
    });

    // Close mobile nav on window resize if it becomes desktop size
    $(window).on('resize', function() {
      if ($(window).width() >= 992) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle').attr('aria-expanded', 'false');
      }
    });

    // Prevent body scroll when mobile nav is open
    $('body').on('touchmove', function(e) {
      if ($('body').hasClass('mobile-nav-active')) {
        if (!$(e.target).closest('.mobile-nav').length) {
          e.preventDefault();
        }
      }
    });
  });

})(jQuery);
