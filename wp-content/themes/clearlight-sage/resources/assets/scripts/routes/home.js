export default {
  init() {
    /*
     * Synchronize background videos
     */

    // Get all videos
    var video = {
      blur: document.getElementById("video-blur"),
      sharp: document.getElementById("video-sharp"),
    },
    loadCount = 0;

    // Iterate through both
    Object.keys(video).forEach(key => {
      var obj = video[key];

      obj.addEventListener('loadeddata', function() {
        if(obj.readyState >= 2 && ++loadCount==2) {
          video.blur.play();
          video.sharp.play();
        }

      });
    });

  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
