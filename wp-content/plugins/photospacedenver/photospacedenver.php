<?php
/**
 * Plugin Name: Photospace Custom Functions
 * Plugin URI: http://www.photospacedenver.com/
 * Description: Photospace Custom Functions
 * Version: 1.0
 * Author: Marcus Johnstone
 * Author URI: http://www.mjohnstone.com/
 * License: N/A
 */

if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

//OVERRIDES THE EXISTING GRAVITY FORMS GIF
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
    return "/wp-content/themes/salient-child/images/blank.gif";
}

//ADD FUNCTIONALITY TO WP TO SUPPORT SVG
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Redirect non-admin users to homepage at login
function customer_login_redirect($redirect_to, $request, $user) {
	return (is_array($user->roles) && in_array('administrator', $user->roles)) ? admin_url() : site_url();
} 
add_filter('login_redirect', 'customer_login_redirect', 10, 3);

if (isset($user)) {
	function change_toolbar($wp_toolbar, $user) {
		if ( !current_user_can('manage_options') ) {
			$wp_toolbar->remove_node('wp-logo');
			$wp_toolbar->remove_node('dashboard');
			$wp_toolbar->remove_node('edit-profile');
			$wp_toolbar->remove_node('user-info');
		}
	}
	add_action('admin_bar_menu', 'change_toolbar', 999);
}

//COMMENTED OUT THESE ANCHORS, CLIENT WAS SAYING IT WOULD SCROLL PAST THE THANK YOU MESSAGE
//add_filter("gform_confirmation_anchor_1", create_function("","return 312;"));
//add_filter("gform_confirmation_anchor_9", create_function("","return 145;"));
