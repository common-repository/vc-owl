<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 21-02-2018
 * Time: 03:17 PM
 */

class Visual_Composer_Owl_Mapper {
	private static $_instance = null;

	public function __construct() {
	}

	public static function instance() {
		if ( self::$_instance === null ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function shortcode_args() {
		$_fields = $this->_class();

		/**
		 * General Group
		 */
		$_fields->set_group( __( "Basic" ) )
				->set_textfield( array(
					'heading'          => __( 'Number of Items' ),
					'param_name'       => 'items',
					'std'              => WPBakeryShortCode_vc_owlcarousel::setting_get( 'items' ),
					'description'      => __( 'This variable allows you to set the maximum amount of items displayed at a time with the widest browser width' ),
					'edit_field_class' => 'vc_col-sm-8',
				) )
				->set_textfield( array(
					'heading'    => __( 'Responsive Refresh Rate' ),
					'param_name' => 'responsiverefreshrate',
					'std'        => WPBakeryShortCode_vc_owlcarousel::setting_get( 'responsiveRefreshRate' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Loop Items' ),
					'param_name'  => 'loop',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'loop' ),
					'description' => __( 'Infinity loop. Duplicate last and first items to get loop illusion.' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Center Item' ),
					'param_name'  => 'center',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'center' ),
					'description' => __( 'Display Carousel Center.' ),
				) )
				->set_css_animations( array(
					'param_name' => 'animatein',
					'heading'    => __( "Animate In" ),
					'std'        => WPBakeryShortCode_vc_owlcarousel::setting_get( 'animateIn' ),
				) )
				->set_css_animations( array(
					'param_name' => 'animateout',
					'heading'    => __( "Animate Out" ),
					'std'        => WPBakeryShortCode_vc_owlcarousel::setting_get( 'animateOut' ),
				) )
				->set_textfield( array(
					'heading'     => __( 'fallbackEasing' ),
					'param_name'  => 'fallbackfasing',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'fallbackEasing' ),
					'description' => __( 'Easing for CSS2 $.animate.' ),
				) );


		/**
		 * Only Auto Play
		 */
		$_fields->set_group( __( "Auto Play" ) )
				->set_checkbox( array(
					'heading'     => __( 'Autoplay' ),
					'param_name'  => 'autoplay',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'autoplay' ),
					'description' => __( 'if Checked Autoplay Will Be Enabled' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Autoplay Speed' ),
					'param_name'  => 'autoplayspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'autoplaySpeed' ),
					'description' => __( 'autoplay speed.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Autoplay TimeOut' ),
					'param_name'  => 'autoplaytimeout',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'autoplayTimeout' ),
					'description' => __( 'Change to any int for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.' ),

				) )
				->set_checkbox( array(
					'heading'     => __( 'Pause Auto Play on Hover ' ),
					'param_name'  => 'autoplayhoverpause',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'autoplayHoverPause' ),
					'description' => __( 'Stop autoplay on mouse hover' ),
				) );

		/**
		 * Basic Speed & Auto Play
		 */
		$_fields->set_group( __( 'Speed Control' ) )
				->set_textfield( array(
					'heading'     => __( 'Navigation Speed' ),
					'param_name'  => 'navspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'navSpeed' ),
					'description' => __( 'Navigation speed.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Dots Speed' ),
					'param_name'  => 'dotsspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dotsSpeed' ),
					'description' => __( 'Dots speed.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Smart Speed' ),
					'param_name'  => 'smartspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'smartSpeed' ),
					'description' => __( 'Speed Calculate.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Fluid Speed' ),
					'param_name'  => 'fluidspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'fluidSpeed' ),
					'description' => __( 'Speed Calculate.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Drag End Speed' ),
					'param_name'  => 'dragendspeed',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dragEndSpeed' ),
					'description' => __( 'Drag End speed.' ),

				) );

		/**
		 * Element Settings
		 */
		$_fields->set_group( __( "Elements" ) )
				->set_textfield( array(
					'heading'     => __( 'Item Element' ),
					'param_name'  => 'itemelement',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'itemElement' ),
					'description' => __( 'DOM element type for owl-item.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Nested Item Selector' ),
					'param_name'  => 'nesteditemselector',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'nestedItemSelector' ),
					'description' => __( 'Use it if owl items are deep nested inside some generated content. E.g <code>youritem</code>. Dont use dot before class name.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Navigation Element' ),
					'param_name'  => 'navelement',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'navElement' ),
					'description' => __( 'DOM element type for a single directional navigation link.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Navigation Container' ),
					'param_name'  => 'navcontainer',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'navContainer' ),
					'description' => __( 'Set your own container for nav.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Dots Container' ),
					'param_name'  => 'dotscontainer',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dotsContainer' ),
					'description' => __( 'Set your own container for nav.' ),

				) );

		/**
		 * Videos
		 */
		$_fields->set_group( __( "Video" ) )
				->set_checkbox( array(
					'param_name' => 'video',
					'heading'    => __( "Video" ),
					'desciption' => __( "Enable fetching YouTube/Vimeo/Vzaar videos." ),
					'std'        => WPBakeryShortCode_vc_owlcarousel::setting_get( 'video' ),
				) )
				->set_textfield( array(
					'heading'     => __( 'Video Height' ),
					'param_name'  => 'videoheight',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'videoHeight' ),
					'description' => __( 'Set height for videos.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Video Width' ),
					'param_name'  => 'videowidth',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'videoWidth' ),
					'description' => __( 'Set width for videos.' ),

				) );


		/**
		 * Navigation & Pagination
		 */
		$_fields->set_group( __( 'Navigation & Pagination' ) )
				->set_textfield( array(
					'heading'     => __( 'Start Position' ),
					'param_name'  => 'startposition',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'startPosition' ),
					'description' => __( 'Start position or URL Hash string like \'#id\'.' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'URL Listener' ),
					'param_name'  => 'urlhashlistener',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'URLhashListener' ),
					'description' => __( 'Listen to url hash changes. data-hash on items is required.' ),

				) )
				->set_checkbox( array(
					'heading'     => __( 'Navigation' ),
					'param_name'  => 'nav',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'nav' ),
					'description' => __( 'Display "next" and "prev" buttons.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Navigation Text' ),
					'param_name'  => 'navtext',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'navText' ),
					'description' => __( 'You can customize your own text for navigation. To get empty buttons use navigationText : false. Also HTML can be used here' ),

				) )
				->set_checkbox( array(
					'heading'          => __( 'rewind' ),
					'param_name'       => 'rewind',
					'edit_field_class' => 'vc_col-sm-6',
					'std'              => WPBakeryShortCode_vc_owlcarousel::setting_get( 'rewind' ),
					'description'      => __( 'Go backwards when the boundary has reached.' ),
				) )
				->set_textfield( array(
					'heading'     => __( 'Navigation SlideBy' ),
					'param_name'  => 'slideby',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'navElement' ),
					'description' => __( 'Navigation slide by x. <code>"page"</code> string can be set to slide by page.' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Dots Navigation' ),
					'param_name'  => 'dots',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dots' ),
					'description' => __( 'Show dots navigation.' ),

				) )
				->set_textfield( array(
					'heading'     => __( 'Dots Each' ),
					'param_name'  => 'dotseach',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dotsEach' ),
					'description' => __( 'Show dots each x item.' ),

				) )
				->set_checkbox( array(
					'heading'     => __( 'Dots Data' ),
					'param_name'  => 'dotdata',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'dotData' ),
					'description' => __( 'Used by <code>data-dot</code> content.' ),

				) )
				->set_group( '' );


		/**
		 * CSS Style | Auto Height | Transitions
		 */
		$_fields->set_group( __( "CSS Styles" ) )
				->set_textfield( array(
					'param_name'  => 'margin',
					'heading'     => __( "Margin" ),
					'description' => __( "Enter Only Numeric Value." ),
				) )
				->set_textfield( array(
					'param_name'  => 'stagepadding',
					'heading'     => __( "Lef & Right Padding" ),
					'description' => __( "Padding left and right on stage (can see neighbours)." ),
				) )
				->set_textfield( array(
					'param_name'  => 'merge',
					'heading'     => __( "merge" ),
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'merge' ),
					'description' => __( "Merge option requires <code>data-merge=\"number_items_to_merge\"</code> on any child element (can be nested as well). There is a sibling option called mergeFit which fits merged elements to screen size. " ),
				) )
				->set_textfield( array(
					'param_name'  => 'mergefit',
					'heading'     => __( "mergeFit" ),
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'mergeFit' ),
					'description' => __( "Fit merged items if screen is smaller than items value." ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Auto Width' ),
					'param_name'  => 'autowidth',
					'description' => '',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'autoWidth' ),
				) )
				->set_group( '' );

		/**
		 * Lazy Load
		 */
		$_fields->set_group( __( "Lazy Load" ) )
				->set_checkbox( array(
					'heading'     => __( 'Lazy Load' ),
					'param_name'  => 'lazyload',
					'description' => __( "Lazy load images. data-src and data-src-retina for highres. Also load images into background inline style if element is not <img>" ),
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'lazyLoad' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Lazy Content' ),
					'param_name'  => 'lazycontent',
					'description' => __( "lazyContent was introduced during beta tests but i removed it from the final release due to bad implementation. It is a nice options so i will work on it in the nearest feature." ),
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'lazyContent' ),
				) )
				->set_group( "" );

		/**
		 * Mouse events
		 */
		$_fields->set_group( __( "Mouse Events" ) )
				->set_checkbox( array(
					'heading'     => __( 'Mouse Drag' ),
					'param_name'  => 'mousedrag',
					'description' => '',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'mouseDrag' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Touch Drag' ),
					'param_name'  => 'touchdrag',
					'description' => '',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'touchDrag' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Pull Drag' ),
					'param_name'  => 'pulldrag',
					'description' => '',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'pullDrag' ),
				) )
				->set_checkbox( array(
					'heading'     => __( 'Free Drag' ),
					'param_name'  => 'freedrag',
					'description' => '',
					'std'         => WPBakeryShortCode_vc_owlcarousel::setting_get( 'freeDrag' ),
				) );

		/**
		 * Callbacks
		 */
		$_fields->set_group( __( "Callback" ) )
				->set_textfield( array(
					'heading'    => __( 'afterLazyLoad' ),
					'param_name' => 'afterlazyload',
					'std'        => WPBakeryShortCode_vc_owlcarousel::setting_get( 'afterLazyLoad' ),
				) );


		return $_fields->settings_section( array(

			"name"                    => __( "VC Owl Carousel2" ),
			'description'             => __( 'Add OWL Carousel2 To Visual Composer' ),
			"base"                    => "vc_owlcarousel",
			'category'                => __( "Content" ),
			'icon'                    => VC_OWL_URL . 'assets/owl-icon.png',
			"as_parent"               => array( 'only' => 'vc_owlcarousel_item' ),
			"content_element"         => true,
			"show_settings_on_create" => true,
			"is_container"            => true,
			'custom_markup'           => '
			<div class="wpb_vc_owl_slider_holder wpb_holder clearfix vc_container_for_children">
			%content%
			</div>
			<div class="tab_controls">
			    <a class="add_tab" title="' . esc_html__( 'Add Slide' ) . '"><span class="vc_icon"></span> 
			    <span class="tab-label">' . esc_html__( 'Add Slide' ) . '</span></a>
			</div>
		',
			"js_view"                 => 'VCOwlSliderView',
			'admin_enqueue_js'        => array( VC_OWL_URL . 'assets/admin/admin.js' ),
			'admin_enqueue_css'       => array( VC_OWL_URL . 'assets/admin/admin.css' ),
		) );

	}


	private function _class() {
		return new VSP_VC_Fields();
	}
}

return Visual_Composer_Owl_Mapper::instance();
