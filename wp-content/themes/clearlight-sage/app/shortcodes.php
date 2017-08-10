<?php

namespace App;

/**
 * Custom calendar events feed Shortcode
 */
add_shortcode('section', function ($atts) {
  extract( shortcode_atts( array(
    'color' => 'white',
  ), $atts) );

  ob_start();
  ?>

  </div>
  </div>
  </div>
  </section>
  <section class="background-<?php echo $color; ?>">
  <div class="container">
  <div class="row">
  <div class="col l9">

  <?php

  // Return output
  return ob_get_clean();
});
