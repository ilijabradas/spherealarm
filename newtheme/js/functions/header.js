/* eslint-disable */
/* global WPURLS */
import size from './size';

const sphere = window.sphere || {};

sphere.header = {
  init () {
    sphere.debug = true;
    if (sphere.debug) {
      console.log('sphere.header');
    }
    this.primaryMenuToggleOpen();
    this.scrollToSectionFromHeader();
    this.scrollToSectionFromFooter();

    this.breakPointCheck();

    history.pushState(null, null, window.location.pathname);

  },
  primaryMenuToggleOpen () {
    $(document)
      .on('click', '.btn-menu', function (event) {
        event.preventDefault();
        $(this)
          .toggleClass('active');
        $('nav')
          .toggleClass('expanded');
      });
  },
  scrollToSectionFromHeader () {
    $('.primary').find('a').on('click', function (event) {
      if($(this).text().indexOf('PRIVACY') >= 0 || $(this).text().indexOf('REGISTRATION') >= 0
      || $(this).text().indexOf('SUPPORT') >= 0) {
        return;
      }
        event.preventDefault();
      if(window.location.href.indexOf('register') >= 0 || window.location.href.indexOf('return') >= 0 ) {
        if ($(this).text().indexOf('ABOUT US') >= 0) {
          window.location.replace(`${WPURLS.siteurl}/#about-us`);

          $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top - 100,
          });
        }
        if ($(this).text().indexOf('CONTACT US') >= 0) {
          window.location.replace(`${WPURLS.siteurl}/#contact-us`);

          $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top - 100,
          });
        }
      }
        var section = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(section).offset().top - 100,
          });
      $('nav').removeClass('expanded');
      $('.btn-menu').removeClass('active');
      });
  },
  scrollToSectionFromFooter () {
    $('.secondary').find('a').on('click', function (event) {
      if($(this).text().indexOf('Privacy') >= 0 || $(this).text().indexOf('Registration') >= 0
        || $(this).text().indexOf('Return Policy') >= 0 || $(this).text().indexOf('Support') >= 0) {
        return;
      }
      event.preventDefault();

      var section = $(this).attr('href');
      $('html, body').animate({
        scrollTop: $(section).offset().top - 100,
      });
      $('nav').removeClass('expanded');
      $('.btn-menu').removeClass('active');
    });
  },
  breakPointCheck () {
    if (size.current === this.size) {
      // no breakpoint change
      return;
    }
    this.size = size.current;
    if (sphere.debug) {
      console.log('sphere.header.breakPointCheck ||', `${size.current} ||`);
    }

    // if (size.current === 'screen-xxs' || size.current === 'screen-xs' || size.current === 'screen-sm') {
    //
    // } else {
    //
    // }
  },
};

$(document)
  .ready(() => {
    if ($('header').length) {
      sphere.header.init();
    }
  });
$(window)
  .on('resize', () => {
    $('nav').removeClass('expanded');
    $('.btn-menu').removeClass('active');
    sphere.header.breakPointCheck();
  });
