import Macy from "macy";

export default {
  init() {
    // Masonry layout for the image galleries
    let gallery = Macy({
      container: '#bricks',
      trueOrder: false,
      waitForImages: false,
      margin: 24,
      columns: 4,
      breakAt: {
        1200: 4,
        992: 3,
        600: 2,
        400: 1,
      },
    });

    gallery.runOnImageLoad(function () {
      gallery.recalculate(true, true);
    });
  },
  finalize() {
    $('.modaal-gallery').modaal({
      type: 'image',
    });
  },
};
