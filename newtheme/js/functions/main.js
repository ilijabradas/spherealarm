/* global Modernizr */
/* global $ */

import size from './size';
// import helpers from './helpers';

const sphere = window.sphere || {};

sphere.main = {
  init () {
    sphere.debug = true;
    if (sphere.debug) {
      console.log('Welcome To Sphere');
      console.log('sphere.main');
    }
    this.toggleConsoleLog(false);
    this.checkSize();

    // helpers.backGroundElementSrc('.background-hero-section');
    $(window)
      .on('load', () => {
      });
  },
  checkSize () {
    $.each(size, (index) => {
      size[index] = false;
    });
    if (Modernizr.mq('only all and (max-width: 479px)')) {
      size['screen-xxs'] = true;
      size.current = 'screen-xxs';
    } else if (Modernizr.mq('only all and (min-width: 480px) and (max-width: 767px)')) {
      size['screen-xs'] = true;
      size.current = 'screen-xs';
    } else if (Modernizr.mq('only all and (min-width: 768px) and (max-width: 1023px)')) {
      size['screen-sm'] = true;
      size.current = 'screen-sm';
    } else if (Modernizr.mq('only all and (min-width: 1024px) and (max-width: 1199px)')) {
      size['screen-md'] = true;
      size.current = 'screen-md';
    } else if (Modernizr.mq('only all and (min-width: 1200px) and (max-width: 1599px)')) {
      size['screen-lg'] = true;
      size.current = 'screen-lg';
    } else if (Modernizr.mq('only all and (min-width: 1600px)')) {
      size['screen-elg'] = true;
      size.current = 'screen-elg';
    }
  },
  toggleConsoleLog (bool) {
    if (bool) {
      window.console = {};
      console.log = function () {
      };
    }
  },
  setCookie (cname, cvalue, exdays) {
    const day = new Date();
    day.setTime(day.getTime() + (exdays * 24 * 60 * 60 * 1000));
    const expires = `expires=${day.toUTCString()}`;
    document.cookie = `${cname}=${cvalue}; ${expires}`;
  },
  getCookie (cname) {
    const name = `${cname}=`;
    const cok = document.cookie.split(';');
    for (let index = 0; index < cok.length; index++) {
      let cookie = cok[index];
      while (cookie.charAt(0) === ' ') {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(name) === 0) {
        return cookie.substring(name.length, cookie.length);
      }
    }
    return '';
  }
};

$(document)
  .ready(() => {
    sphere.main.init();
  });

$(window)
  .on('resize', () => {
    sphere.main.checkSize();
  });
