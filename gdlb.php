<?php
/*
Plugin Name:  GDPR Lightbox
Plugin URI:   https://github.com/mirkoschubert/gdpr-lightbox
Description:  A WordPress Lightbox Plugin which can be used as a GDPR two click solution instead of oembeds.
Version:      0.1.0
Author:       Mirko Schubert
Author URI:   https://mirkoschubert.de/
License:      GPL3
License URI:  https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
Text Domain:  gdlb
Domain Path:  /languages

Minimal Contact Form is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
Minimal Contact Form is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Minimal Contact Form. If not, see https://github.com/mirkoschubert/gdpr-lightbox/blob/master/license.txt.
*/

// Disable direct access
if (!defined( 'ABSPATH' )) exit();

$gdlb_wp_version = '4.9.6';
$gdlb_version = '0.1.0';
$gdlb_plugin  = esc_html__('GDPR Lightbox', 'gdlb');
$gdlb_slug = dirname(plugin_basename(__FILE__));
$gdlb_path    = plugin_basename(__FILE__);
$gdlb_options = get_option('gdlb_options');

include 'admin/gdlb-options.php';
//include 'gdlb-form.php';


/**
 * Activation Hook
 * @since 0.1.0
 */
function gdlb_plugin_activation() {
  
  // Write default options to database
  add_option( 'gdlb_options', array('theme' => 'light', 'selectors' => '.entry-content, .gallery', 'caption' => 1, 'exif' => 1), '', 'yes');  
}
register_activation_hook( __FILE__, 'gdlb_plugin_activation' );


/**
 * Deactivation Hook
 * @since 0.1.0
 */
function gdlb_plugin_deactivation() {

  // FOR TESTING: delete options from database
  delete_option('gdlb_options');
  
}
register_deactivation_hook( __FILE__, 'gdlb_plugin_deactivation' );


/**
 * Uninstallation Hook
 * @since 0.1.0
 */
function gdlb_plugin_uninstall() {

  // delete options from database
  delete_option('gdlb_options');
}
register_uninstall_hook (__FILE__, 'gdlb_plugin_uninstall');


/**
 * Loads the text domain of the plugin
 * @since 0.1.0
 */
function gdlb_init() {
  global $gdlb_slug;
  load_plugin_textdomain('gdlb', false, $gdlb_slug .'/languages/');
}
add_action( 'plugins_loaded', 'gdlb_init' );


/**
 * Checks the version of WordPress and deactivates the Plugin when necessary
 * @since 0.1.0
 */
function gdlb_check_version() {
  global $pagenow, $gdlb_wp_version, $gdlb_path, $gdlb_slug, $gdlb_plugin;

  $wp_version = get_bloginfo('version');

  if ($pagenow === 'plugins.php' || ($pagenow === 'options-general.php' && $_GET['page'] === $gdlb_slug)) {
    if (version_compare($wp_version, $gdlb_wp_version, '<')) {
      if (is_plugin_active($gdlb_path)) add_action( 'admin_notices', 'gdlb_version__error' );
    }  
  }
}
add_action('admin_init', 'gdlb_check_version');


/**
 * Error message for version check
 * @since 0.1.0
 */
function gdlb_version__error() {
  global $gdlb_plugin, $gdlb_wp_version;
  $class = 'notice notice-error';
  $msg  = "<strong>$gdlb_plugin</strong>";
  $msg .= ' ' . esc_html__('requires WordPress', 'gdlb') . ' ' . $gdlb_wp_version;
  $msg .= ' ' . esc_html__('or higher!', 'gdlb');
  $msg .= ' ' . esc_html__('Please upgrade WordPress and try again.', 'gdlb');

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $msg ); 
}


/**
 * Enqueues plugin frontend scripts
 * @since 0.1.0
 */
function gdlb_scripts() {
  if(!is_admin())	{
    wp_enqueue_script('jquery');
    wp_enqueue_script('gdlb-script', plugins_url( '/js/gdlb-script.js', __FILE__ ), 'jquery', true);
    wp_enqueue_style('gdlb-style', plugins_url('/css/style.css',__FILE__));
    wp_localize_script('gdlb-script', 'minimal_contact_form', array( 'gdlb_ajaxurl' => admin_url( 'admin-ajax.php')));
  }
}
add_action('wp_enqueue_scripts', 'gdlb_scripts');


/**
 * Enqueues plugin admin scripts
 * @since 0.1.0
 */
function gdlb_admin_scripts($hook) {
  global $gdlb_slug;

  if($hook !== 'settings_page_' . $gdlb_slug) return;
  wp_enqueue_style('gdlb-admin-style', plugins_url('/css/admin.css',__FILE__));
}
add_action('admin_enqueue_scripts', 'gdlb_admin_scripts');


/**
 * Sets a link to the settings page in the plugin list
 * @since 0.1.0
 */
function gdlb_plugin_action_links($links, $file) {
	
	global $gdlb_path, $gdlb_slug;
	
	if ($file == $gdlb_path) array_unshift($links, '<a href="'. get_admin_url() .'options-general.php?page='. $gdlb_slug .'">'. esc_html__('Settings', 'gdlb') .'</a>');
	return $links;
}
add_filter ('plugin_action_links', 'gdlb_plugin_action_links', 10, 2);
