<?php

namespace App;

/**
 * Add Defer / Async Attributes to WordPress Scripts
 * @author Matthew Horne - http://matthewhorne.me/defer-async-wordpress-scripts/
 */
add_filter('script_loader_tag', function($tag, $handle) {
  // Add the handles for the scripts that we want to defer to this array right here:
  $scripts_to_defer = array(
    'contact-form-7',
    'sage/main.js',
    'wpgmza_api_call',
    'wpgmaps_core'
  );
  foreach($scripts_to_defer as $defer_script) {
    if ($defer_script == $handle) {
      $tag = str_replace(' src', ' defer="defer" src', $tag);
    }
  }
  return $tag;
}, 10, 2);


/**
 * Remove query strings from static resources (JS and CSS)
 * @link https://www.keycdn.com/support/remove-query-strings-from-static-resources/
 */
function remove_script_version( $src ){
  $parts = explode( '?ver', $src );
  return $parts[0];
}
add_filter( 'script_loader_src', __NAMESPACE__ . '\\remove_script_version', 15, 1 );
add_filter( 'style_loader_src', __NAMESPACE__ . '\\remove_script_version', 15, 1 );
