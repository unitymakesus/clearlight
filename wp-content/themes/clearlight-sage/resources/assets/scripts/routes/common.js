export default {
  init() {
    // Mobile side nav
    $('#mobile-menu-button').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'right', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens
    });
  },
  finalize() {
    // Blur the background of the head banner thing
    var bg_img = $('body .page-header').attr('style');
    $('head').append(
      '<style type="text/css">.banner::before {' + bg_img + '} .banner::after {background-color:rgba(233, 247, 245, .5);}</style>'
    );

    // Lightbox gallery thumbnail images
    $('[class*="gallery-size"] img').materialbox();

    // Lazy load images a la David Walsh
    // https://davidwalsh.name/lazyload-image-fade
    [].forEach.call(document.querySelectorAll('noscript'), function(noscript) {
      var img = new Image();
      img.setAttribute('data-src', '');
      noscript.parentNode.insertBefore(img, noscript);
      img.onload = function() {
        img.removeAttribute('data-src');
      };
      img.src = noscript.getAttribute('data-src');
    });

    /**
     * Form label controls
     */
    $('.wpcf7-form-control-wrap').children('input[type="text"], input[type="email"], input[type="tel"], textarea').each(function() {
      // Remove br
      $(this).parent().prevAll('br').remove();

      // Move label to after field element
      $(this).parent().prevAll('label').insertAfter($(this).parent());

      // Set field wrapper to active
      $(this).on('focus', function() {
        $(this).parent().addClass('active');
      });

      // Remove field wrapper active state
      $(this).on('blur', function() {
        var val = $.trim($(this).val());

        if (!val) {
          $(this).parent().removeClass('active');
        }
      });
    });

    $('.wpcf7-form-control-wrap').find('.has-free-text').each(function() {
      var $input = $(this).find('input[type="radio"], input[type="checkbox"]');

      $input.on('focus', function() {
        $input.parent().addClass('active');
      })
    });
  },
};
