<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 21-02-2018
 * Time: 03:03 PM
 */
if ( ! defined( "ABSPATH" ) ) {
	die;
}

if ( ! function_exists( 'vc_owl_remap_settings' ) ) {
	/**
	 * @param $atts
	 *
	 * @return array
	 */
	function vc_owl_remap_settings( $atts ) {
		$orginal = WPBakeryShortCode_vc_owlcarousel::set();
		$return  = array();
		foreach ( $orginal as $key => $value ) {
			$k = strtolower( $key );
			if ( isset( $atts[ $k ] ) ) {
				$return[ $key ] = $atts[ $k ];
			}
		}
		return $return;
	}
}

if ( ! class_exists( 'Visual_Composer_OWL' ) ) {
	/**
	 * Class Visual_Composer_OWL
	 *
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 * @since 1.0
	 */
	class Visual_Composer_OWL extends VSP_Framework {
		/**
		 * text_domain
		 *
		 * @var string
		 */

		public $text_domain = 'vc-owl';
		/**
		 * version
		 *
		 * @var string
		 */

		public $version = '1.1';
		/**
		 * file
		 *
		 * @var string
		 */

		public $file = VC_OWL_FILE;
		/**
		 * slug
		 *
		 * @var string
		 */

		public $slug = 'vc-owl';
		/**
		 * db_slug
		 *
		 * @var string
		 */

		public $db_slug = 'vc_owl';
		/**
		 * name
		 *
		 * @var string|void
		 */

		public $name = VC_OWL_NAME;
		/**
		 * hook_slug
		 *
		 * @var string
		 */

		public $hook_slug = 'vc_owl_';

		/**
		 * Visual_Composer_OWL constructor.
		 */
		public function __construct() {
			$this->row_actions = array(
				'report-buugs' => sprintf( '<a href="%s">%s</a>', 'https://github.com/varunsridharan/vc-owl', __( "Report Bugs" ) ),
			);

			parent::__construct( array(
				'addons'        => false,
				'settings_page' => false,
				'reviewme'      => array(
					'days_after' => 4,
					'type'       => 'plugin',
					'slug'       => 'vc-owl',
					'site'       => 'wordpress',
				),
			) );
		}

		/**
		 *
		 */
		public function wp_init() {
			vsp_load_file( VC_OWL_PATH . 'includes/class-*.php' );
			$mapper = Visual_Composer_Owl_Mapper::instance();

			vc_map( $mapper->shortcode_args() );

			vc_map( array(
				"name"                    => __( "VC Owl Carousel Item" ),
				"base"                    => "vc_owlcarousel_item",
				'is_container'            => true,
				'content_element'         => true,
				'as_child'                => array( 'only' => 'vc_owlcarousel' ),
				"show_settings_on_create" => false,
				"params"                  => array(
					array(
						'type'       => 'css_editor',
						'heading'    => __( 'CSS box' ),
						'param_name' => 'css',
						'group'      => __( 'Design Options' ),
					),
				),

			) );

			wp_register_script( 'vc_owlcarousel_js', VC_OWL_URL . 'assets/owl.carousel.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'vc_owlcarousel_init', VC_OWL_URL . 'assets/owl.carousel.init.js', array( 'vc_owlcarousel_js' ), false, true );
			wp_enqueue_style( 'vc_owlcarousel_css', VC_OWL_URL . 'assets/owl.carousel.min.css' );
			wp_enqueue_style( 'vc_owlcarousel_css_theme', VC_OWL_URL . 'assets/owl.theme.default.min.css', array( 'vc_owlcarousel_css' ) );
		}

		/**
		 * VSP_Framework::__init_plugin()
		 *
		 * @see VSP_Framework::__init_plugin() .
		 */
		public function plugin_init() {
		}

		/**
		 * VSP_Framework::__register_hooks
		 *
		 * @see   VSP_Framework::__register_hooks
		 */
		public function register_hooks() {
		}

		/**
		 * VSP_Framework::__settings_init
		 *
		 * @see VSP_Framework::__settings_init
		 */
		public function settings_init_before() {
		}

		/**
		 * \VSP_Framework::__load_required_files
		 *
		 * @see \VSP_Framework::__load_required_files
		 */
		public function load_files() {
		}
	}
}