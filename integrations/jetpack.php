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
