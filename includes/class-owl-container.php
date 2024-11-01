<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 21-02-2018
 * Time: 03:09 PM
 */

class WPBakeryShortCode_vc_owlcarousel extends WPBakeryShortCode {

    protected $controls_css_settings = 'tc vc_control-container';
    protected $controls_list         = array( 'edit', 'clone', 'delete' );

    public function __construct($settings) {
        parent::__construct($settings);
    }

    static function setting_get($key = '') {
        $data = self::set();

        if( isset($data[$key]) ) {
            return $data[$key];
        }
        return FALSE;
    }

    static function set() {
        return array(
            'items'                 => '3',
            'margin'                => '0',
            'loop'                  => 'false',
            'center'                => 'false',
            'mouseDrag'             => 'true',
            'touchDrag'             => 'true',
            'pullDrag'              => 'true',
            'freeDrag'              => 'false',
            'stagePadding'          => '0',
            'merge'                 => 'false',
            'mergeFit'              => 'true',
            'autoWidth'             => 'false',
            'startPosition'         => '0',
            'URLhashListener'       => 'false',
            'nav'                   => 'false',
            'rewind'                => 'true',
            'navText'               => 'next,prev',
            'navElement'            => 'div',
            'slideBy'               => '1',
            'dots'                  => 'true',
            'dotsEach'              => 'false',
            'dotData'               => 'false',
            'lazyLoad'              => 'false',
            'lazyContent'           => 'false',
            'autoplay'              => 'false',
            'autoplayTimeout'       => '5000',
            'autoplayHoverPause'    => 'false',
            'smartSpeed'            => '250',
            'fluidSpeed'            => 'false', # Given as number
            'autoplaySpeed'         => 'false',
            'navSpeed'              => 'false',
            'dotsSpeed'             => 'false', # Number / bool
            'dragEndSpeed'          => 'false',
            'callbacks'             => 'true', # True
            'responsive'            => '', # Object Object
            'responsiveRefreshRate' => '200',
            'responsiveBaseElement' => 'window', # Window
            'video'                 => 'false',
            'videoHeight'           => 'false',
            'videoWidth'            => 'false',
            'animateOut'            => 'false',
            'animateIn'             => 'false',
            'fallbackEasing'        => 'swing',
            'info'                  => 'false',
            'nestedItemSelector'    => 'false',
            'itemElement'           => 'div',
            'stageElement'          => 'div',
            'navContainer'          => 'false',
            'dotsContainer'         => 'false',
        );
    }

    public function contentAdmin($atts, $content = NULL) {
        $width                = $custom_markup = '';
        $shortcode_attributes = array( 'width' => '1/1' );
        foreach( $this->settings['params'] as $param ) {
            if( $param['param_name'] != 'content' ) {
                if( isset($param['value']) && is_string($param['value']) ) {
                    $shortcode_attributes[$param['param_name']] = __($param['value']);
                } else if( isset($param['value']) ) {
                    $shortcode_attributes[$param['param_name']] = $param['value'];
                }
            } else if( $param['param_name'] == 'content' && $content == NULL ) {
                $content = __($param['value']);
            }
        }
        extract(shortcode_atts($shortcode_attributes, $atts));

        $output = '';

        $elem = $this->getElementHolder($width);

        $inner = '';
        foreach( $this->settings['params'] as $param ) {
            $param_value = '';
            $param_value = isset(${$param['param_name']}) ? ${$param['param_name']} : '';
            if( is_array($param_value) ) {
                // Get first element from the array
                reset($param_value);
                $first_key   = key($param_value);
                $param_value = $param_value[$first_key];
            }
            $inner .= $this->singleParamHtmlHolder($param, $param_value);
        }
        //$elem = str_ireplace('%wpb_element_content%', $iner, $elem);
        $tmp = '';
        // $template = '<div class="wpb_template">'.do_shortcode('[vc_accordion_tab title="New Section"][/vc_accordion_tab]').'</div>';

        if( isset($this->settings["custom_markup"]) && $this->settings["custom_markup"] != '' ) {
            if( $content != '' ) {
                $custom_markup = str_ireplace("%content%", $tmp . $content, $this->settings["custom_markup"]);
            } else if( $content == '' && isset($this->settings["default_content_in_template"]) && $this->settings["default_content_in_template"] != '' ) {
                $custom_markup = str_ireplace("%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"]);
            } else {
                $custom_markup = str_ireplace("%content%", '', $this->settings["custom_markup"]);
            }
            //$output .= do_shortcode($this->settings["custom_markup"]);
            $inner .= do_shortcode($custom_markup);
        }
        $elem   = str_ireplace('%wpb_element_content%', $inner, $elem);
        $output = $elem;

        return $output;
    }

    protected function content($atts, $content = NULL) {
        $settings = shortcode_atts(self::set(), vc_owl_remap_settings($atts));
        $settings['id'] = 'vc_owlcarousel_' . uniqid();
        wp_localize_script('vc_owlcarousel_init', $settings['id'], $settings);
        $output = '<div class="' . $settings['id'] . ' owl-carousel owl-theme vc_owlcarousels" data-settings="' . $settings['id'] . '">';
        $output .= do_shortcode($content);
        return $output . '</div>';
    }

}