/* global Modernizr */
/* global $ */
/* global WPURLS */

import helpers from './helpers';
import storageapi from './storage-api';

require('jquery-validation');

const sphere = window.sphere || {};

sphere.registration_step_one = {
  init () {
    sphere.debug = true;
    if (sphere.debug) {
      console.log('sphere.registration_step_one');
    }
    helpers.customSelectState('.custom-select-state');
    this.validateStepOne();
    this.saveInputValues();
    this.setInputValues();
    this.tooltipHtml();

    storageapi.initLocalStorage();

    $('body')
      .on('click', (event) => {
        if (event.target.id === 'help') {
          return;
        }
        if ($('.tooltip-image').length) {
          $('[data-toggle=\'tooltip\']')
            .tooltip('hide');
        }
      });

    $(window)
      .on('load', () => {
      });
  },

  validateStepOne () {
    $.validator.setDefaults({
      debug: true,
      validClass: 'sucess',
      errorClass: 'invalid',
      errorElement: 'div',
    });
    const form = $('#step-one');

    form.validate({
      rules: {
        name: 'required',
        street: {
          required: true,
        },
        city: 'required',
        zip: 'required',
        phone: {
          required: true,
          number: true,
        },
        id_number: 'required',
      },
      messages: {
        name: 'Field is required',
        street: 'Field is required',
        city: 'Field is required',
        zip: 'Field is required',
        phone: {
          required: 'Field is required',
          number: 'Specify a valid phone number',
        },
        id_number: 'Field is required',
      },
    });
    $('#submit-step-one')
      .on('click', () => {
        if ($('.custom-select-trigger')
            .text() === 'State') {
          $('#state-error')
            .show();
        } else {
          $('#state-error')
            .hide();
        }
        if (form.valid() && $('.custom-select-trigger')
            .text() !== 'State') {
          // history.pushState({}, '', `${WPURLS.siteurl}/registration/step-one/`);
          window.location.replace(`${WPURLS.siteurl}/register/step-two/`);
        } else {
          console.log('Form Invalid');
        }
      });
  },
  saveInputValues () {
    $('#step-one input, #step-one select')
      .each(function () {
        const input = $(this);
        input.on('change', (event) => {
          if ($(event.target)
              .is('select')) {
            $('div.custom-select-state')
              .find('.custom-select-trigger')
              .text($('select')
                .find(':selected')
                .text());
            if ($('select')
                .find(':selected')
                .text() !== 'State') {
              $('#state-error')
                .hide();
            }
          }

          const key = input.attr('name');
          const registrationData = {
            [key]: $.trim(input.val()),
          };
          storageapi.setRegistration(registrationData);
          console.log(`Type: ${input.attr('type')} Name: ${input.attr('name')} Value: ${input.val()}`);
        });
      });
  },
  setInputValues () {
    const data = storageapi.getRegistration();
    _.mapValues(data, (value, key) => {
      if (key === 'state') {
        $('select')
          .val(value)
          .prop('selected', true);
        $(document)
          .find('.custom-select-trigger')
          .text($('select')
            .find(':selected')
            .text());
        $('.custom-options').find(`[data-value='${value}']`).addClass('selection');
      } else {
        $(`#${key}`)
          .val(value);
      }
    });
  },
  tooltipHtml () {
    $('[data-toggle="tooltip"]')
      .tooltip({
        html: true,
        trigger: 'click',
        title: '<em>Tooltip</em> <u>with</u> <b>HTML</b>',
        template: `<div class="tooltip-image" role="tooltip">
        <div class="tooltip-arrow"></div>
        <div class="image-wrapper"> 
                <img src=${WPURLS.tooltip}>    
        </div>
        </div>`,
      });
  },
};

$(document)
  .ready(() => {
    if ($('#step-one').length) {
      sphere.registration_step_one.init();
    }
  });

$(window)
  .on('resize', () => {
    if ($('#step-one').length) {
      sphere.registration_step_one.checkSize();
    }
  });
