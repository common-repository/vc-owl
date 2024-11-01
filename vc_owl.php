<?php
/*
 * Plugin Name: OWL Carousel2 For Visual Composer
 * Plugin URI: http://wordpress.org/plugins/vc-owl
 * Description: Add a carousel to Visual Composer
 * Version: 1.1
 * Author: Varun Sridharan
 * Author URI: http://varunsridharan.in
*/

if ( ! function_exists( 'vc_owl' ) ) {
	define( "VC_OWL_NAME", __( 'Owl Carousel2 For Visual Composer' ) );
	define( "VC_OWL_VERSION", '1.0' );
	define( 'VC_OWL_FILE', plugin_basename( __FILE__ ) );
	define( 'VC_OWL_PATH', plugin_dir_path( __FILE__ ) ); # Plugin DIR
	define( 'VC_OWL_URL', plugins_url( '', __FILE__ ) . '/' );  # Plugin URL

	require_once( VC_OWL_PATH . 'vsp-framework/vsp-init.php' );

	if ( function_exists( 'vsp_maybe_load' ) ) {
		vsp_maybe_load( VC_OWL_PATH, array(
			'integrations' => array( 'visual-composer' ),
		), 'vc_owl_init' );
	}

	/*
	 * Returns Instance of OWL
	 */
	function vc_owl() {
		return Visual_Composer_OWL::instance();
	}

	function vc_owl_init() {
		require_once( VC_OWL_PATH . 'bootstrap.php' );
		return vc_owl();
	}
}