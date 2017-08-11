export default {
  init() {
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

    // Mobile side nav
    $('#mobile-menu-button').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'right', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    $('[class*="gallery-size"] img').materialbox();
  },
};
