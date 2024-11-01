<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 26-04-2018
 * Time: 01:28 PM
 *
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 * @since      1.0
 * @package    vsp-framework/integrations/visual-composer
 * @copyright  GPL V3 Or greater
 */

/**
 * Interface VSP_VC_Element_Interface
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since 1.0
 */
interface VSP_VC_Element_Interface {
	public function register_assets();

	public function load_assets();
}

abstract class VSP_VC_Element implements VSP_VC_Element_Interface {
	/**
	 * class_file
	 *
	 * @var string
	 */
	public $class_file = '';

	/**
	 * shortcode_file
	 *
	 * @var string
	 */
	public $shortcode_file = '';

	/**
	 * instance_id
	 *
	 * @var string
	 */
	public $instance_id = '';

	/**
	 * settings
	 *
	 * @var null
	 */
	public $settings = null;

	/**
	 * base
	 *
	 * @var null
	 */
	public $base = null;

	/**
	 * init_hook
	 *
	 * @var string
	 */
	public $init_hook = '';

	/**
	 * elements_path
	 *
	 * @var string
	 */
	public $elements_path = '';

	/**
	 * VSP_VC_Element constructor.
	 */
	public function __construct() {
		add_action( $this->init_hook, array( &$this, 'on_hook_callback' ) );
	}

	/**
	 * Triggers When $this->init_hook is called.
	 */
	public function on_hook_callback() {
		add_action( 'init', array( &$this, 'on_init' ) );
		add_action( 'vc_before_init', array( &$this, 'before_vc_init' ) );
		add_action( 'vc_after_init', array( &$this, 'on_after_vc_init' ) );
		add_action( 'vc_base_register_front_css', array( &$this, 'register_frontend_assets' ) );
		add_action( 'vc_base_register_admin_css', array( &$this, 'register_admin_assets' ) );
		add_action( 'vc_backend_editor_enqueue_js_css', array( &$this, 'load_backend_assets' ) );
		add_action( 'vc_frontend_editor_enqueue_js_css', array( &$this, 'load_frontend_assets' ) );
	}

	/**
	 * On Inits.
	 */
	public function on_init() {
		if ( ! empty( $this->class_file ) ) {
			include $this->get_file_path();
		}
		$this->vc_map();
		$this->init();
	}

	/**
	 * @return string
	 */
	protected function get_file_path() {
		return vsp_unslashit( $this->elements_path ) . '/' . $this->class_file;
	}

	/**
	 *
	 */
	public function vc_map() {
		vc_map( $this->get_vc_settings() );
	}

	/**
	 * @return array
	 */
	public function get_vc_settings() {
		if ( empty( $this->settings ) ) {
			$this->settings = $this->get_settings();
		}
		return $this->settings;
	}

	/**
	 * @return array
	 */
	public function get_settings() {
		return array();
	}

	/**
	 *
	 */
	public function init() {
	}

	/**
	 *
	 */
	public function on_after_vc_init() {
		$this->settings = $this->get_settings();
		$this->after_vc_init();
	}

	/**
	 *
	 */
	public function after_vc_init() {
	}

	/**
	 *
	 */
	public function before_vc_init() {
	}

	/**
	 *
	 */
	public function register_frontend_assets() {
		$this->register_assets();
	}

	/**
	 *
	 */
	public function register_admin_assets() {
		$this->register_assets();
	}

	/**
	 *
	 */
	public function load_backend_assets() {
		$this->load_assets();
	}

	/**
	 *
	 */
	public function load_frontend_assets() {
		$this->load_assets();
	}

	/**
	 * @param $args
	 *
	 * @return array
	 */
	public function get_section( $args ) {
		return vc_map_shortcode_defaults( $this->fields->settings_section( $args ), $this->get_defaults() );
	}

	/**
	 * @return array
	 */
	public function get_defaults() {
		return array();
	}
}
