<?php
/**
 * Jetpack specific integrations.
 *
 * @package     posterno-third-party
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register listings within the sitemap.
 *
 * @param array $post_types list of support post types.
 * @return array
 */
function pno_jetpack_add_listings_to_sitemap( $post_types ) {
	$post_types[] = 'listings';
	return $post_types;
}
add_filter( 'jetpack_sitemap_post_types', 'pno_jetpack_add_listings_to_sitemap' );

/**
 * Skip expired listings within jetpacks sitemap.
 *
 * @param boolean $skip_post whether to skip a post or not.
 * @param object  $post the post object.
 * @return boolean
 */
function pno_jetpack_skip_expired_non_public_listings( $skip_post, $post ) {
	if ( 'listings' !== $post->post_type ) {
		return $skip_post;
	}
	if ( ! pno_are_expired_listings_public() && pno_is_listing_expired( $post->ID ) ) {
		return true;
	}
	return $skip_post;
}
add_action( 'jetpack_sitemap_skip_post', 'pno_jetpack_skip_expired_non_public_listings', 10, 2 );
