<?php
namespace Phox_Host\Elementor\Functions;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

/**
 * WooCommerce Handler
 *
 * @since 2.0.0
 */
class Woo_Handler{

    /**
     * A reference to an instance of this class.
     *
     * @since 2.0.0
     * @var   object
     */
    private static $instance = null;

    /**
     * Returns the instance.
     *
     * @since  2.0.0
     * @return object
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor for the class
     *
     * @since  2.0.0
     */
    public function __construct(){

        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
            add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_link_fragments' ) );
        } else {
            add_filter( 'add_to_cart_fragments', array( $this, 'cart_link_fragments' ) );

        }
    }

    /**
     * Cart link fragments
     *
     * @since  2.0.0
     * @return array
     */
    public function cart_link_fragments( $fragments ) {

        global $woocommerce;

        $wdes_fragments = array(
	        '.wdes-site-cart-total-val' => $this->total_tamplate(),
	        '.wdes-site-cart-count-val' => $this->count_template(),
        );

        foreach ( $wdes_fragments as $selector => $template ) {
            ob_start();
            echo $template;
            $fragments[ $selector ] = ob_get_clean();
        }

        return $fragments;

    }

    /**
     * Get Value of count and totals
     *
     * @since  2.0.0
     * @param $val
     * @return false|mixed
     */
    public function get_value($val){

        if( $val !== 'count' && $val !== 'totals' ) return false;

        $is_edit_mode = \Elementor\Plugin::instance()->editor->is_edit_mode();

        if ( ( $is_edit_mode && ! wp_doing_ajax() ) || null === \WC()->cart ) {
            $count = '';
            $totals = '';
        } else {
            $count = \WC()->cart->get_cart_contents_count();
            $totals = wp_kses_data( WC()->cart->get_cart_subtotal() );
        }

        $data = [ 'count' => $count, 'totals' => $totals];
        return $data[$val];

    }

    /**
     * Total Template
     *
     * @since  2.0.0
     */
    public function total_tamplate(){

        $totals = $this-> get_value('totals');

        return sprintf( '<span class="wdes-site-cart-total-val">%s</span>', $totals );

    }

    /**
     * Count Template
     *
     * @since  2.0.0
     */
    public function count_template(){

        $count = $this->get_value('count');

        return sprintf( '<span class="wdes-site-cart-count-val">%s</span>', $count );

    }


}

