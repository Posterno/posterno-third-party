<?php
/**
 * Yoast SEO specific integrations.
 *
 * @package     posterno-third-party
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register listings custom fields as yoast variables.
 *
 * @return void
 */
function pno_yoast_register_listings_custom_fields_vars() {

	$exclude         = [
		'listing_location',
		'listing_gallery',
		'listing_opening_hours',
		'listing_social_media_profiles',
		'listing_description',
		'listing_title',
	];
	$listings_fields = pno_get_listings_fields( $exclude );

	if ( is_array( $listings_fields ) && ! empty( $listings_fields ) ) {
		foreach ( $listings_fields as $field ) {
			wpseo_register_var_replacement( '%%' . $field['meta'] . '%%', 'pno_yoast_get_variable_value', 'advanced', $field['name'] );
		}
	}
}
add_action( 'wpseo_register_extra_replacements', 'pno_yoast_register_listings_custom_fields_vars' );
