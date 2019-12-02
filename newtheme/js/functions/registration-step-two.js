/* eslint-disable */
/* global Modernizr */
/* global $ */
/* global WPURLS */

import helpers from './helpers';
import storageapi from './storage-api';

require('jquery-validation');

const sphere = window.sphere || {};

sphere.registration_step_two = {
  init () {
    sphere.debug = true;
    if (sphere.debug) {
      console.log('sphere.registration_step_two');
    }
    helpers.customSelectReason('.custom-select-reason');
    this.customValidatorMethods();
    this.validateStepTwo();
    this.saveInputValues();
    this.setInputValues();
    this.preventMultipleCheckboxSelect('.usage .checkbox-input');
    this.preventMultipleCheckboxSelect('.entries .checkbox-input');
    this.preventMultipleCheckboxSelect('.people .checkbox-input');
    storageapi.initLocalStorage();

    if ($('.input-wrapper.other').is(':visible')) {
      $('.input-wrapper.reason').css('margin-bottom', '27px');
    }
    else {
      $('.input-wrapper.reason').css('margin-bottom', '38px');
    }
    $(window)
      .on('load', () => {
      });
  },
  preventMultipleCheckboxSelect (element) {
    $(element)
      .on('click', function () {
        $(element)
          .not(this)
          .prop('checked', false);
      });
  },

  customValidatorMethods () {
    $.validator.addMethod('usageInput', function () {
      if($('.usage input:checked').length > 0) {
        return true;
      } else{
        return false;
      }
    }, 'Check one of the above options');

    $.validator.addMethod('entriesInput', function () {
      if($('.entries input:checked').length > 0) {
        return true;
      } else{
        return false;
      }
    }, 'Check one of the above options');

    $.validator.addMethod('peopleInput', function () {
      if($('.people input:checked').length > 0) {
        return true;
      } else{
        return false;
      }
    }, 'Check one of the above options');

  },
  validateStepTwo () {
    $.validator.setDefaults({
      debug: true,
      validClass: 'sucess',
      errorClass: 'invalid',
      errorElement: 'div',
    });


    var checkboxes_usage = $('.usage .checkbox-input');
    var checkbox_usage_names = $.map(checkboxes_usage, function(e, i) {
      return $(e).attr("name")
    }).join(" ");

    var checkboxes_entries = $('.entries .checkbox-input');
    var checkbox_entries_names = $.map(checkboxes_entries, function(e, i) {
      return $(e).attr("name")
    }).join(" ");

    var checkboxes_people = $('.people .checkbox-input');
    var checkbox_people_names = $.map(checkboxes_people, function(e, i) {
      return $(e).attr("name")
    }).join(" ");

    const form = $('#step-two');

    form.validate({
      rules: {
        usage: {
          usageInput: true
        },
        entries: {
          entriesInput: true
        },
        people: {
          peopleInput: true
        },
        other: {
          required: true
        }
      },
      errorPlacement: function(error, element) {
        error.appendTo(element.parents('.input-wrapper'));
      },
      groups: {
        usage: checkbox_usage_names,
        entries: checkbox_entries_names,
        people: checkbox_people_names
      }
    });
    $('#submit-step-two')
      .on('click', (e) => {
        e.preventDefault();
        if ($('.custom-select-trigger')
            .text() === 'Select') {
          $('#reason-error')
            .show();
        } else {
          $('#reason-error')
            .hide();
        }
        if (form.valid() && $('.custom-select-trigger')
            .text() !== 'Select') {
          console.log(form.valid());
          this.submitForm();
            $('#submit-step-two').prop('disabled', true);
        } else {
          console.log('Form Invalid');
        }
      });
  },
  submitForm() {

    // Compile our data object - notice that it is only the email as opposed to the admin-ajax method.
    // The nonce is sent in a request header - see beforeSend in $.ajax
    // No action is required, we specify the direct endpoint we created above as the url in $.ajax
    var data = JSON.stringify(storageapi.getFromLocalStorage());

    console.log(data);
    // Fire our ajax request!
    $.ajax({
      method: 'POST',
      contentType: 'application/json',
      // Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
      url: WPURLS.api_url + 'save/',
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
          // history.pushState({}, '', `${WPURLS.siteurl}/`);
          window.location.replace(`${WPURLS.siteurl}/register/success/`);
          storageapi.reset();
        }

      },
      fail : function(response) {
        console.log(response);
          $('#submit-step-two').prop('disabled', false);
        $('#result').addClass('error').html('Something went wrong. Refresh page and try again.');
      }
    });
  },
  saveInputValues () {
    $('#step-two input, #step-two select')
      .each(function () {
        const input = $(this);
        input.on('change', (event) => {
          if ($(event.target)
              .is('select')) {
            $('div.custom-select-reason')
              .find('.custom-select-trigger')
              .text($('select')
                .find(':selected')
                .text());

            if ($('select')
                .find(':selected')
                .text() !== 'Select') {
              $('#reason-error')
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
      if (key === 'reason') {
        $('select')
          .val(value)
          .prop('selected', true);
        $(document)
          .find('.custom-select-trigger')
          .text($('select')
            .find(':selected')
            .text());
        if (value === 'OT') {
          $('.input-wrapper.other').show();
        }
        $('.custom-options').find(`[data-value='${value}']`).addClass('selection');
      }
      if (key === 'usage') {
        $(`.usage .checkbox-input:checkbox[value=${value}]`)
          .prop('checked', true);
      }
      if (key === 'entries') {
        $(`.entries .checkbox-input:checkbox[value=${value}]`)
          .prop('checked', true);
      }
      if (key === 'people') {
        $(`.people .checkbox-input:checkbox[value=${value}]`)
          .prop('checked', true);
      } else {
        $(`#${key}`)
          .val(value);
      }
    });
  },
};

$(document)
  .ready(() => {
    if ($('#step-two').length) {
      sphere.registration_step_two.init();
    }
  });

$(window)
  .on('resize', () => {
    if ($('#step-two').length) {
      sphere.registration_step_two.checkSize();
    }
  });
