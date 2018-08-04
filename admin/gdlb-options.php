<?php

// Disable direct access
if (!defined( 'ABSPATH' )) exit();


/**
 * Initialize the options menu page
 * @since 0.1.0
 */
function gdlb_options_page() {
  global $gdlb_plugin, $gdlb_slug;
  add_options_page(
    $gdlb_plugin,
    __( 'GDPR Lightbox', 'gdlb' ),
    'manage_options',
    $gdlb_slug,
    'gdlb_render_options_page'
  );
}
add_action( 'admin_menu', 'gdlb_options_page' );


/**
 * Initialize the settings
 * @since 0.1.0
 */
function gdlb_options_init() {
  register_setting('gdlb_plugin_options', 'gdlb_options', array('type' => 'string', 'sanitize_callback' => 'gdlb_validate_options'));
}
add_action( 'admin_init', 'gdlb_options_init' );


/**
 * Validates Options
 * @since 0.1.0
 */
function gdlb_validate_options($input) {

  $validated = [];

  // theme
  $validated['theme'] = (isset($input['theme'])) ? $input['theme'] : 'light';
  // selectors
  if (!isset($input['selectors'])) $input['selectors'] = '.entry-content, .gallery';
  $validated['selectors'] = ($input['selectors'].length > 0) ? $input['selectors'] : '.entry-content, .gallery';
  // caption
  if (!isset($input['caption'])) $input['caption'] = 0;
  $validated['caption'] = ($input['caption'] == 1) ? 1 : 0;
  // exif
  if (!isset($input['exif'])) $input['exif'] = 0;
  $validated['exif'] = ($input['exif'] == 1) ? 1 : 0;

  return $validated;
}


/**
 * Display the options page
 * @since 0.1.0
 */
function gdlb_render_options_page() {

  global $gdlb_version, $gdlb_plugin, $gdlb_options;

  include_once('gdlb-options-page.php');
}

