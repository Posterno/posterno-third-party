<?php
/**
 * Load third party compatibility files when a 3rd party plugin is enabled.
 *
 * @package     posterno-third-party
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Load plugin specific integration files.
 *
 * @return void
 */
function pno_3rd_party_loader() {

	$yoast = defined( 'WPSEO_FILE' );

	if ( $yoast ) {
		require_once PNO_PLUGIN_DIR . 'includes/components/posterno-third-party/integrations/yoast.php';
	}

}
add_action( 'plugins_loaded', 'pno_3rd_party_loader' );
