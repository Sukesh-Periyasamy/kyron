(function ($) {
  "use strict";

  // Mobile Navigation
  if ($('.main-nav').length) {
    var $mobile_nav = $('.main-nav').clone().prop({
      class: 'mobile-nav d-lg-none'
    });
    $('body').append($mobile_nav);
    $('#header .container').append('<button type="button" class="mobile-nav-toggle d-lg-none" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobile-nav"><i class="fa fa-bars"></i></button>');
    $('body').append('<div class="mobile-nav-overly"></div>');

    // Toggle mobile nav
    $(document).on('click', '.mobile-nav-toggle', function (e) {
      e.preventDefault();
      $('body').toggleClass('mobile-nav-active');
      $('.mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('.mobile-nav-overly').toggle();

      // Update ARIA attributes
      var isExpanded = $('body').hasClass('mobile-nav-active');
      $(this).attr('aria-expanded', isExpanded);

      // Prevent body scroll when menu is open
      if (isExpanded) {
        $('body').css('overflow', 'hidden');
      } else {
        $('body').css('overflow', '');
      }
    });

    // Handle dropdown menus
    $(document).on('click', '.mobile-nav .drop-down > a', function (e) {
      e.preventDefault();
      $(this).next().slideToggle(300);
      $(this).parent().toggleClass('active');
    });

    // Close menu when clicking overlay
    $(document).on('click', '.mobile-nav-overly', function (e) {
      if ($('body').hasClass('mobile-nav-active')) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle i').removeClass('fa-times').addClass('fa-bars');
        $('.mobile-nav-overly').fadeOut();
        $('.mobile-nav-toggle').attr('aria-expanded', 'false');
        $('body').css('overflow', '');
      }
    });

    // Close menu when clicking outside
    $(document).click(function (e) {
      var container = $(".mobile-nav, .mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('.mobile-nav-toggle i').removeClass('fa-times').addClass('fa-bars');
          $('.mobile-nav-overly').fadeOut();
          $('.mobile-nav-toggle').attr('aria-expanded', 'false');
          $('body').css('overflow', '');
        }
      }
    });

    // Close menu when clicking a link (except dropdown toggles)
    $(document).on('click', '.mobile-nav a:not(.drop-down > a)', function () {
      if ($('body').hasClass('mobile-nav-active')) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle i').removeClass('fa-times').addClass('fa-bars');
        $('.mobile-nav-overly').fadeOut();
        $('.mobile-nav-toggle').attr('aria-expanded', 'false');
        $('body').css('overflow', '');
      }
    });

    // Handle window resize
    $(window).on('resize', function () {
      if ($(window).width() >= 992) {
        // Close mobile menu on desktop
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('.mobile-nav-toggle i').removeClass('fa-times').addClass('fa-bars');
          $('.mobile-nav-overly').hide();
          $('.mobile-nav-toggle').attr('aria-expanded', 'false');
          $('body').css('overflow', '');
        }
      }
    });

  } else if ($(".mobile-nav, .mobile-nav-toggle").length) {
    $(".mobile-nav, .mobile-nav-toggle").hide();
  }

})(jQuery);

