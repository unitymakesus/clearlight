export default {
  init() {
    /**
     * Add video or fallback to image
     */

    // Test for IE browsers
    function isIE() {
      const myNav = navigator.userAgent.toLowerCase();
      return (myNav.indexOf('msie') !== -1) ? parseInt(myNav.split('msie')[1], 10) : false;
    }

    // Test for old IE or iPads
    const isIEOld = isIE() && isIE() < 9;
    const isiPad = navigator.userAgent.match(/iPad/i);

    // Set constants for blurred videos
    const img_blur = $('#video-blur-wrapper').data('poster');
    const mp4_blur = $('#video-blur-wrapper').data('mp4');
    const webm_blur = $('#video-blur-wrapper').data('webm');

    // Set constants for sharp videos
    const img_sharp = $('#video-sharp-wrapper').data('poster');
    const mp4_sharp = $('#video-sharp-wrapper').data('mp4');
    const webm_sharp = $('#video-sharp-wrapper').data('webm');

    if ($(window).width() > 599 && !isIEOld && !isiPad) {

      let el_blur = '';
      let el_sharp = '';
      // let load_count = 0;

      // Make blurred video element
      el_blur += `<video class="" id="video-blur" playsinline mute loop preload="auto" poster="${img_blur}">`;
      el_blur += `<source src="${webm_blur}" type="video/webm">`;
      el_blur += `<source src="${mp4_blur}" type="video/mp4">`;
      el_blur += '</video>';

      // Make sharp video element
      el_sharp += `<video class="" id="video-sharp" playsinline mute loop preload="auto" poster="${img_sharp}">`;
      el_sharp += `<source src="${webm_sharp}" type="video/webm">`;
      el_sharp += `<source src="${mp4_sharp}" type="video/mp4">`;
      el_sharp += '</video>';

      // Create deferred objects so we can run a function when they are both done
      let blur_d = $.Deferred();
      let sharp_d = $.Deferred();

      // Add the videos to their assigned wrappers and return a deferred promise
      blur_d.resolve( $('#video-blur-wrapper').html(el_blur) );
      sharp_d.resolve( $('#video-sharp-wrapper').html(el_sharp) );

      // When both deferred promises are returned
      $.when(blur_d, sharp_d).done(function() {

        // Get all videos
        var video = {
          blur: document.getElementById("video-blur"),
          sharp: document.getElementById("video-sharp"),
        },
        loadCount = 0;

        // Iterate through both
        Object.keys(video).forEach(key => {
          var obj = video[key];

          // When both videos are loaded, play them!
          obj.addEventListener('loadeddata', function() {
            if(obj.readyState >= 2 && ++loadCount==2) {
              video.blur.play();
              video.sharp.play();
            }

          });
        });
      });

    }

  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
