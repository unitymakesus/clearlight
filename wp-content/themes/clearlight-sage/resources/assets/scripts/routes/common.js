// import Materialize from 'materialize-css';

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
    // JavaScript to be fired on all pages, after page specific JS is fired
    // Materialize.scrollFire([
    //   {selector: 'img.lazyload', offset: 500, callback: function(el) {
    //     Materialize.fadeInImage($(el));
    //   }},
    // ]);

    $('[class*="gallery-size"] img').materialbox();
  },
};
