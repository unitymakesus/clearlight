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
    $('noscript').each(function() {
      if (!$(this).hasClass('gtm')) {
        var img = new Image();
        img.setAttribute('data-src', '');
        $(this).before(img);
        img.onload = function() {
          img.removeAttribute('data-src');
        };
        img.src = $(this).attr('data-src');
      }
    });

    // Responsive table stuff
    $('.hentry table').each(function() {
      var headers = [];
      var i;

      // put table headers in array
      $(this).find('thead th').each(function() {
        headers.push($(this).html());
      });

      // set data-label for each td in the rows
      $(this).find('tbody tr').each(function() {
        i = 0;
        $(this).find('td').each(function() {
          $(this).attr('data-label', headers[i]);
          i++;
        });
      });
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

    //Accordoin Script
      var acc = document.getElementsByClassName("accordion");
      var i;

      for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
          /* Toggle between adding and removing the "active" class,
          to highlight the button that controls the panel */
          this.classList.toggle("active");

          /* Toggle between hiding and showing the active panel */
          var panel = this.nextElementSibling;
          if (panel.style.display === "block") {
            panel.style.display = "none";
          } else {
            panel.style.display = "block";
          }
    });
}

  },
};
