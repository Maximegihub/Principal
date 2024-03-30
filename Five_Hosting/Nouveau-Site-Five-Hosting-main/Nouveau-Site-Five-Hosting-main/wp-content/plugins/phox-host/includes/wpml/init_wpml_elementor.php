<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Init Wpml Elementor 
 *
 * This class is intended to run all classes with fields that will use to translate the widget
 *  
 * @since 1.2.0
 */

class Init_Wpml_Elementor {

    /**
	 * Wpml Elementor construction
	 *
	 * run the method that fire the classes
	 *
	 * @since  1.2.0
	 */
    public function __construct () {

        $this-> add_support_section_header () ;   
        $this-> add_support_forms () ;
        $this-> add_support_plans();    
        $this-> add_support_tabs();    
        $this-> add_support_faq();   
        $this-> add_support_carousels(); 
        $this-> add_support_partners();   
        $this-> add_support_features_boxs();
        $this-> add_support_breadcrumb();
        $this-> add_support_app();
        $this-> add_support_button();
        $this->add_support_alert();
        $this->add_price_table();
        $this->add_testimonial();
        $this->add_dual_button();

    }

    /**
     * Add Support Section Header
     *
     * Fire the class to register the fields for section header element 
     *  
     * @since 1.2.0
     */
    public function add_support_section_header () {

        $widget = new Section_Header ();
        
    }

    /**
     * Add Support Forms
     *
     * Fire the class to register the fields for Forms element 
     *  
     * @since 1.2.0
     */
    public function add_support_forms () {

        $widget = new Forms ();
        
    }

     /**
     * Add Support Plans
     *
     * Fire the class to register the fields for Plans element 
     *  
     * @since 1.2.0
     */
    public function add_support_plans () {

        $widget = new Plans ();
        
    }

    /**
     * Add Support Tabs
     *
     * Fire the class to register the fields for Tabs element 
     *  
     * @since 1.2.0
     */
    public function add_support_tabs () {

        $widget = new Tabs ();
        
    }

    /**
     * Add Support FAQ
     *
     * Fire the class to register the fields for Forms element 
     *  
     * @since 1.2.0
     */
    public function add_support_faq () {

        $widget = new FAQ ();
        
    }

    /**
     * Add Support Carousels
     *
     * Fire the class to register the fields for Carousels element 
     *  
     * @since 1.2.0
     */
    public function add_support_carousels () {

        $widget = new Carousels ();
        
    }

    /**
     * Add Support Partners
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_partners () {

        $widget = new Partners ();
        
    }

    /**
     * Add Support Features Boxs
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_features_boxs () {

        $widget = new Features_Boxs ();
        
    }

    /**
     * Add Support Features Boxs
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_breadcrumb () {

        $widget = new Breadcrumb ();
        
    }

     /**
     * Add Support Features Boxs
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_app () {

        $widget = new App ();
        
    }
    
     /**
     * Add Support Button
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_button () {

        $widget = new Button ();
        
    }

     /**
     * Add Support Button
     *
     * Fire the class to register the fields for Partners element 
     *  
     * @since 1.2.0
     */
    public function add_support_alert () {

        $widget = new Alert ();
        
    }

    /**
     * Add Price Table
     *
     * Fire the class to register the fields for Partners element
     *
     * @since 1.4.9
     */
    public function add_price_table(){
        $widget = new Price_Table();
    }

    /**
     * Add Testimonial
     *
     * Fire the class to register the fields for Partners element
     *
     * @since 1.4.9
     */
    public function add_testimonial(){
        $widget = new Testimonial();
    }

    /**
     * Add Dual Button
     *
     * Fire the class to register the fields for Partners element
     *
     * @since 1.4.9
     */
    public function add_dual_button(){
        $widget = new Dual_Button();
    }


}
