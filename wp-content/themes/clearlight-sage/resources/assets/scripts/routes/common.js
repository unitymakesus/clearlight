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
    var bg_img = $('body.page .page-header').attr('style');
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
  },
};
