import Macy from "macy";

export default {
  init() {
    Macy({
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
  },
};
