/* eslint-disable */
/* global Modernizr */
/* global $ */
/* global WPURLS */

import helpers from './helpers';
import storageapi from './storage-api';

require('jquery-validation');

const sphere = window.sphere || {};

sphere.return = {
  init () {
    sphere.debug = true;
    if (sphere.debug) {
      console.log('sphere.return');
    }
    helpers.customSelectAction('.custom-select-action');
    helpers.customSelectReturn('.custom-select-return');
    this.validateReturn();
    this.saveInputValues();
    this.setInputValues();

    storageapi.initLocalStorage2();
    $(window)
      .on('load', () => {
      });
  },

  validateReturn () {
    $.validator.setDefaults({
      debug: true,
      validClass: 'sucess',
      errorClass: 'invalid',
      errorElement: 'div',
    });


    const form = $('#return-form');

    form.validate({
      rules: {
        name: 'required',
        email: {
          required: true,
          email: true
        },
        order: 'required',
        replacement: 'required',
      },
      messages: {
        name: 'Field is required',
        email: {
          required: 'Field is required',
          number: 'Specify a valid email address',
        },
        order: 'Field is required',
        replacement: 'Field is required'
      },
    });
    $('#submit-return')
      .on('click', (e) => {
        e.preventDefault();
        if ($('.custom-select-trigger-action')
            .text() === 'Please select an action') {
          $('#action-error')
            .show();
        } else {
          $('#action-error')
            .hide();
        }
        if ($('.custom-select-trigger-return')
            .text() === 'Please select return reason') {
          $('#return-error')
            .show();
        } else {
          $('#return-error')
            .hide();
        }
        if (form.valid() && $('.custom-select-trigger-action')
            .text() !== 'Please select an action'  && $('.custom-select-trigger-return')
            .text() !== 'Please select return reason') {
          console.log(form.valid());
          this.submitForm();
        } else {
          console.log('Form Invalid');
        }
      });
  },
  submitForm() {

    // Compile our data object - notice that it is only the email as opposed to the admin-ajax method.
    // The nonce is sent in a request header - see beforeSend in $.ajax
    // No action is required, we specify the direct endpoint we created above as the url in $.ajax
    var data = JSON.stringify(storageapi.getFromLocalStorage2());

    console.log(data);
    // Fire our ajax request!
    $.ajax({
      method: 'POST',
      contentType: 'application/json',
      // Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
      url: WPURLS.api_url + 'send/',
      data: data,
      beforeSend: function (xhr) {
        // Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
        xhr.setRequestHeader( 'X-WP-Nonce', WPURLS.api_nonce );
      },
      success : function(response) {
        console.log(response);
        if (response.error) {
          $('#result').addClass('error').html(response.message);
        }
        if (response.success) {
          $('#result').addClass('success').html(response.message);

          // window.location.replace(`${WPURLS.siteurl}/registration/success/`);
          $('#return-form').trigger('reset');
          storageapi.reset2();
        }
      },
      fail : function(response) {
        console.log(response);
        $('#result').addClass('error').html('Something went wrong. Refresh page and try again.');
      }
    });
  },
  saveInputValues () {
    $('#return-form input, #return-form select, #return-form textarea')
      .each(function () {
        const input = $(this);
        input.on('change', (event) => {
          if ($(event.target).is('select')) {
            $('div.custom-select-action')
              .find('.custom-select-trigger-action')
              .text($('select')
                .find(':selected')
                .text());
            $('div.custom-select-return')
              .find('.custom-select-trigger-return')
              .text($('select')
                .find(':selected')
                .text());

            if ($('select.custom-select-action').find(':selected').text() !== 'Please select an action') {
              $('#action-error').hide();
            }

            if ($('select.custom-select-return').find(':selected').text() !== 'Please select return reason') {
              $('#return-error').hide();
            }
          }
          const key = input.attr('name');
          const returnData = {
            [key]: $.trim(input.val()),
          };
          storageapi.setReturn(returnData);
          console.log(`Type: ${input.attr('type')} Name: ${input.attr('name')} Value: ${input.val()}`);
        });
      });
  },
  setInputValues () {
    const data = storageapi.getReturn();
    _.mapValues(data, (value, key) => {
      if (key === 'action') {
        $('select.custom-select-action')
          .val(value)
          .prop('selected', true);
        $(document)
          .find('.custom-select-trigger-action')
          .text($('select.custom-select-action')
            .find(':selected')
            .text());
        if (value === 'Exchange' || value === 'Other') {
          $('.input-wrapper.replacement').show();
        }
        $('.custom-options-action').find(`[data-value='${value}']`).addClass('selection');

        if (value !== 'Please select an action') {
          $('.input-wrapper.return').show();
        }
      }

      if (key === 'return') {
        $('select.custom-select-return')
          .val(value)
          .prop('selected', true);
        $(document)
          .find('.custom-select-trigger-return')
          .text($('select.custom-select-return')
            .find(':selected')
            .text());

        $('.custom-options-return').find(`[data-value='${value}']`).addClass('selection');
      } else {
        $(`#${key}`)
          .val(value);
      }
    });
  },
};

$(document)
  .ready(() => {
    if ($('#return-form').length) {
      sphere.return.init();
    }
  });

$(window)
  .on('resize', () => {
    if ($('#return-form').length) {
      sphere.return.checkSize();
    }
  });
