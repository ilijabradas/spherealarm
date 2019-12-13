/* eslint-disable */
const Draggabilly = require('draggabilly');
$().ready(readyFunction);

const rzObject = {};
rzObject.location = 'index';

function readyFunction() {
  let active = false;
  if (active) {
    $.responsivizr({
      helper: 'dev',
      debug: 1,
      overlay: '../../wp-content/themes/newtheme/mockups/return_mobile.png',
    });
    // $('.turn-on').click(); // UNCOMMENT TO ACTIVATE OVERLAY ON READY
  }
}


(function($) {
  $.responsivizr = function(opts) {
    const defaults = {
      helper: false,
      debug: false,
      overlay: false
    };
    $.rz.options = $.extend(defaults, opts);
    $.rz.helper();
  };

  $.rz = {

    options: '',
    // HELPER OVERLAY FUNCTION (SHOWS SIZE INFO AND OVERLAY MOCKUPS)
    helper(size) {
      if (!$('.rz-helper').length) {
        $('<div class="rz-helper"><span class="size"></span> <a href="javascript:;" class="turn-on">Overlay</a></div>').appendTo('body');
      }
      if ($.rz.options.helper == 'dev') {
        $('.rz-helper').addClass('dev');

        if ($.rz.options.overlay) {
          $(document).on('click', '.rz-helper .turn-on', () => {
            if ($('.rz-overlay').length) {
              $('.rz-overlay').toggle();
              $('html').toggleClass('whiteout');
            } else {
              $('html').addClass('whiteout');

              const cookieName = `rzObject.${rzObject.location}`;
              let position = '100.40';
              if ($.cookie(cookieName) !== undefined) {
                position = $.cookie(cookieName);
              }
              const posArray = position.split('.');

              $(`<div class="rz-overlay"><img style="left: ${posArray[0]}px; top: ${posArray[1]}px; " src="${$.rz.options.overlay}"/></div>`).appendTo('body');
              var dragElem = $('.rz-overlay img')[0];
              $('.rz-overlay img').on('dragstart', (event) => {
                event.preventDefault();
              });

              const draggie = new Draggabilly(dragElem, {});

              draggie.on('dragEnd', () => {
                const x = parseInt($('.rz-overlay img').css('left'), 10);
                const y = parseInt($('.rz-overlay img').css('top'), 10);
                position = `${x}.${y}`;
                $.cookie(cookieName, position);
                console.log(position);
              });

              document.onkeydown = checkKey;

              function checkKey(e) {
                e = e || window.event;

                let x = parseInt($('.rz-overlay img').css('left'), 10);
                let y = parseInt($('.rz-overlay img').css('top'), 10);
                let isValidControl = false;

                if (e.keyCode == '37') {
                  // left arrow
                  x--;
                  isValidControl = true;
                }
                if (e.keyCode == '39') {
                  // right arrow
                  x++;
                  isValidControl = true;
                }
                if (e.keyCode == '38') {
                  // up arrow
                  y--;
                  isValidControl = true;
                }
                if (e.keyCode == '40') {
                  // down arrow
                  y++;
                  isValidControl = true;
                }

                if (!isValidControl) return;

                $('.rz-overlay img').css('left', x);
                $('.rz-overlay img').css('top', y);

                position = `${x}.${y}`;
                $.cookie(cookieName, position);
              }
            }
          });
        }
      }
      const mapper = {
        'good-size': 'Good width, 950px or more',
        'bad-size': 'Warning: Increase window width to 950px or more'
      };
      $('.rz-helper .size').text(`W: ${$(window).width()}px`);
    }
  };
}(jQuery));
