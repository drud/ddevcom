/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        $(document).ready(function(){

          if ($(window).scrollTop() > 0 ) {
            $('body').addClass('scrolled');
          } else {
            $('body').removeClass('scrolled');
          }

        });

        $(window).scroll(function(){
          if ($(this).scrollTop() > 0 ) {
            $('body').addClass('scrolled');
          } else {
            $('body').removeClass('scrolled');
          }
        });

        $('#modal-video').on('shown.bs.modal', function() {
          $(this).find('iframe').attr('src', 'https://www.youtube.com/embed/rj4WTnZcjjY?modestbranding=1&amp;showinfo=0&amp;rel=0;autoplay=1');
        });

        $('#modal-video').on('hidden.bs.modal', function() {
          $(this).find('iframe').attr('src', '');
        });

        $('.hamburger').on('click', function() {
          $(this).toggleClass('is-active');
          $('body').toggleClass('no-scroll');
          $('.main-navigation-wrapper').toggleClass('is-open');
        });

        $('.product-navigation-toggle__button').on('click', function() {
          $(this).toggleClass('is-active');
          $('.product-navigation__menu').toggleClass('show');
          $('.product-navigation-wrapper').toggleClass('is-open');
        });

        $('.main-navigation__menu > li.menu-item-has-children').hover(function () {
          $(this).find('.sub-menu').addClass('show');
        }, function () {
          $(this).find('.sub-menu').removeClass('show');
        });

        $('.main-navigation__menu > li.menu-item-has-children').focusin(function () {
          $(this).closest('li.menu-item-has-children').find('.sub-menu').addClass('show');
        });

        $('.main-navigation__menu > li.menu-item-has-children').focusout(function () {
          $(this).closest('li.menu-item-has-children').find('.sub-menu').removeClass('show');
        });

        $('.main-navigation-wrapper.is-product .main-navigation__menu > li').focusin(function () {
          $('.main-navigation-toggle').addClass('is-active');
          $('.main-navigation-wrapper').addClass('is-open');
        });

        $('.product-navigation__menu > li.menu-item-has-children').focusin(function () {
          $(this).find('.sub-menu').addClass('show');
        });

        $('.product-navigation__menu > li.menu-item-has-children').focusout(function () {
          $(this).find('.sub-menu').removeClass('show');
        });

        $('.product-navigation-mobile-overlay').click(function () {
          $('.product-navigation__menu').removeClass('show');
          $('.product-navigation-wrapper').removeClass('is-open');
        });

        $('[data-toggle="popover"]').popover({
          trigger: 'hover'
        });

        $('.testimonials-carousel').slick({
          autoplay: true,
          arrows: false
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
