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
		'listing_title',
		'listing_description',
		'listing_social_media_profiles',
		'listing_categories',
		'listing_tags',
		'listing_regions',
		'listing_opening_hours',
		'listing_featured_image',
		'listing_gallery',
		'listing_location',
	];

	$exclude_types = [
		'password',
		'file',
		'social-profiles',
		'listing-category',
		'listing-tags',
		'term-select',
		'term-multiselect',
		'term-checklist',
		'term-chain-dropdown',
		'listing-opening-hours',
		'listing-location',
	];

	$listings_fields = pno_get_listings_fields( $exclude );

	// Exclude fields by type.
	foreach ( $listings_fields as $key => $field ) {
		if ( in_array( $field['type'], $exclude_types ) ) {
			unset( $listings_fields[ $key ] );
		}
	}

	if ( is_array( $listings_fields ) && ! empty( $listings_fields ) ) {
		foreach ( $listings_fields as $field ) {
			wpseo_register_var_replacement( '%%' . $field['meta'] . '%%', 'pno_yoast_get_variable_value', 'advanced', $field['name'] );
		}
	}

	// Add other type of data.
	wpseo_register_var_replacement( '%%listing_address%%', 'pno_yoast_get_listing_address', 'advanced', esc_html__( 'Listing address' ) );

}
add_action( 'wpseo_register_extra_replacements', 'pno_yoast_register_listings_custom_fields_vars' );

/**
 * Retrieve the value associated with the given listing field for Yoast replacements variables.
 *
 * @param string $var the variable to look up.
 * @return string|boolean
 */
function pno_yoast_get_variable_value( $var ) {

	global $post;

	$value           = false;
	$listings_fields = pno_get_listings_fields();
	$field           = wp_list_filter( $listings_fields, [ 'meta' => $var ] );

	if ( is_array( $field ) && ! empty( $field ) ) {

		$field_type = esc_attr( $field[ key( $field ) ]['type'] );

		switch ( $var ) {
			case 'listing_email_address':
				$var = 'listing_email';
				break;
			case 'listing_video':
				$var = 'listing_media_embed';
				break;
		}

		$meta_value = get_post_meta( $post->ID, '_' . $var, true );

		if ( $meta_value ) {
			$value = esc_html( wp_strip_all_tags( pno_display_field_value( $field_type, $meta_value, $field[ key( $field ) ], true ) ) );
		}
	}

	return $value;

}

/**
 * Retrieve the listing address for the yoast variable.
 *
 * @return string
 */
function pno_yoast_get_listing_address() {

	global $post;

	return esc_html( get_post_meta( $post->ID, '_listing_location_address', true ) );
}
