/*eslint-disable*/
import size from './size';
import storageapi from './storage-api';

module.exports = {

  changeImgSource (element, mobileSrc, desktopSrc) {
    if (size.current === 'screen-xxs' || size.current === 'screen-xs' || size.current === 'screen-sm') {
      $(element).attr('src', $(element).data(mobileSrc));
    } else {
      $(element).attr('src', $(element).data(desktopSrc));
    }
  },
  backGroundElementSrc (element) {
    const src = $(element).data('src');
    $(element).css({
      'background-image': `url(${src})`
    });
  },
  setEqualBoxHeight (element) {
    let maxHeight = 0;
    $(element).each(function () {
      if ($(this).height() > maxHeight) {
        maxHeight = $(this).height();
      }
    });
    $(element).height(maxHeight);
  },
  backgroundFix (element) {
    $(element).css('background-attachment', 'scroll');
    $(window).scroll(() => {
      const scrollTop = $(window).scrollTop();
      const photoTop = $(element).offset().top;
      const distance = (photoTop - scrollTop);
      $(element).css('background-position', `center ${distance * -1}px`);
    });
  },

  customSelectState (element) {

    $(element).each(function() {
      const classes = $(this).attr('class');
      const id      = $(this).attr('id');
      const name    = $(this).attr('name');
      let template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });

      template += '</div>';
      template += '<div id="state-error" class="custom-invalid" style="display: none;">Field is required</div>';
      template +=  '</div>';

      $(this).wrap('<div class="custom-select-wrapper"></div>');
      $(this).after(template);
    });

    $(".custom-select-trigger").on("click", function() {
      $('html').one('click',function() {
        $(".custom-select-state").removeClass("opened");
      });
      $(this).parents(".custom-select-state").toggleClass("opened");
      event.stopPropagation();
    });
    $(".custom-option").on("click", function() {
      $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
      if ($(this).data("value") !== 'State') {
        $('#state-error').hide();
      }
      storageapi.setRegistration({state: $(this).data("value")});
      $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
      $(this).addClass("selection");
      $(this).parents(".custom-select-state").removeClass("opened");
      $(this).parents(".custom-select-state").find(".custom-select-trigger").text($(this).text());
    });
  },

  customSelectReason (element) {

    $(element).each(function() {
      const classes = $(this).attr('class');
      const id      = $(this).attr('id');
      const name    = $(this).attr('name');
      let template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });

      template += '</div>';
      template += '<div id="reason-error" class="custom-invalid" style="display: none;">Field is required</div>';
      template +=  '</div>';

      $(this).wrap('<div class="custom-select-wrapper"></div>');
      $(this).after(template);
    });

    $(".custom-select-trigger").on("click", function() {
      $('html').one('click',function() {
        $(".custom-select-reason").removeClass("opened");
      });
      $(this).parents(".custom-select-reason").toggleClass("opened");
      event.stopPropagation();
    });
    $(".custom-option").on("click", function() {

      $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
      if ($(this).data("value") !== 'Select') {
        $('#reason-error').hide();
      }
      if ($(this).data("value") === 'OT') {
        $('.input-wrapper.other').show();
        $('.input-wrapper.reason').css('margin-bottom', '27px');
      }
      else {
        $('.input-wrapper.other input').val('');
        $('.input-wrapper.other').hide();
        storageapi.initLocalStorage().remove('data.registration.other');
        $('.input-wrapper.reason').css('margin-bottom', '38px');

      }
      storageapi.setRegistration({reason: $(this).data("value")});
      $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
      $(this).addClass("selection");
      $(this).parents(".custom-select-reason").removeClass("opened");
      $(this).parents(".custom-select-reason").find(".custom-select-trigger").text($(this).text());
    });
  },

  customSelectAction (element) {

    $(element).each(function() {
      const classes = $(this).attr('class');
      const id      = $(this).attr('id');
      const name    = $(this).attr('name');
      let template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger-action">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options-action">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option-action" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });

      template += '</div>';
      template += '<div id="action-error" class="custom-invalid" style="display: none;">Field is required</div>';
      template +=  '</div>';

      $(this).wrap('<div class="custom-select-wrapper"></div>');
      $(this).after(template);
    });

    $(".custom-select-trigger-action").on("click", function() {
      $('html').one('click',function() {
        $(".custom-select-action").removeClass("opened");
      });
      $(this).parents(".custom-select-action").toggleClass("opened");
      event.stopPropagation();
    });
    $(".custom-option-action").on("click", function() {

      $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
      if ($(this).data("value") !== 'Please select an action') {
        $('#action-error').hide();
        $('.input-wrapper.return').show();
      }
      if ($(this).data("value") === 'Exchange' || $(this).data("value") === 'Other' ) {
        $('.input-wrapper.replacement').show();
      }
      else {
        $('.input-wrapper.replacement input').val('');
        $('.input-wrapper.replacement').hide();
        storageapi.initLocalStorage2().remove('data.return.replacement');

      }
      storageapi.setReturn({action: $(this).data("value")});
      $(this).parents(".custom-options-action").find(".custom-option-action").removeClass("selection");
      $(this).addClass("selection");
      $(this).parents(".custom-select-action").removeClass("opened");
      $(this).parents(".custom-select-action").find(".custom-select-trigger-action").text($(this).text());
    });
  },

  customSelectReturn (element) {

    $(element).each(function() {
      const classes = $(this).attr('class');
      const id      = $(this).attr('id');
      const name    = $(this).attr('name');
      let template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger-return">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options-return">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option-return" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });

      template += '</div>';
      template += '<div id="return-error" class="custom-invalid" style="display: none;">Field is required</div>';
      template +=  '</div>';

      $(this).wrap('<div class="custom-select-wrapper-return"></div>');
      $(this).after(template);
    });

    $(".custom-select-trigger-return").on("click", function() {
      $('html').one('click',function() {
        $(".custom-select-return").removeClass("opened");
      });
      $(this).parents(".custom-select-return").toggleClass("opened");
      event.stopPropagation();
    });
    $(".custom-option-return").on("click", function() {

      $(this).parents(".custom-select-wrapper-return").find("select").val($(this).data("value"));
      if ($(this).data("value") !== 'Please select return reason') {
        $('#return-error').hide();
      }

      storageapi.setReturn({return: $(this).data("value")});
      $(this).parents(".custom-options-return").find(".custom-option-return").removeClass("selection");
      $(this).addClass("selection");
      $(this).parents(".custom-select-return").removeClass("opened");
      $(this).parents(".custom-select-return").find(".custom-select-trigger-return").text($(this).text());
    });
  }
};
