<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Carousels Layout  Loop
 * 
 * This will get all fields that in the loop and transaltion it
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Carousels_Layouts_Loop extends \WPML_Elementor_Module_With_Items  {

    public static $items_field ;

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        $field_name = self::$items_field;

        return $field_name;
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

        $field_name = self::$items_field;

        if ( $field_name === 'the_users_list' ) {

            return array( 'user_name', 'user_website', 'user_comment' );

        }elseif ( $field_name === 'the_members_list' ) {

            return array( 'member_name', 'member_website', 'member_comment' );
        
        }

    }
    
    /**
     * Get Title
     * 
     * @since 1.2.0
     * @param string $field
     * @return string
     * 
     */
    protected function get_title( $field ) {

        switch( $field ) {
            case 'user_name':
                return esc_html__( 'User Name', 'phox-host' );
            case 'user_website':
                return esc_html__( 'User Website', 'phox-host' );
            case 'user_comment':
                return esc_html__( 'User Comment', 'phox-host' );

            case 'member_name':
                return esc_html__( 'Member Name', 'phox-host' );
            case 'member_website':
                return esc_html__( 'Member Website', 'phox-host' );
            case 'member_comment':
                return esc_html__( 'Member Comment', 'phox-host' );
            
            default:
                return '';
        }
       
        
    }
    
    /**
     * Get Editor Type
     * 
     * @param string $field
     * 
     * @since 1.2.0
     * @return string
     */
    protected function get_editor_type( $field ) {
        switch( $field ) {
            case 'user_name':
            case 'user_website':
                return 'LINE';
            case 'user_comment':
                return 'AREA';

            case 'member_name':
            case 'features_items':
                return 'LINE';
            case 'member_comment':
                return 'AREA';
            
            default:
                return '';
        }
    }

    /**
	 * @param $element
	 *
	 * @return mixed
	 */
	public function get_items( $element ) {
        
        if( isset ($element[ \WPML_Elementor_Translatable_Nodes::SETTINGS_FIELD ]['the_users_list'] ) ) {

            self::$items_field = 'the_users_list';

        }elseif ( isset ($element[ \WPML_Elementor_Translatable_Nodes::SETTINGS_FIELD ]['the_members_list'] ) ) {

            self::$items_field = 'the_members_list';

        }
        
		return $element[ \WPML_Elementor_Translatable_Nodes::SETTINGS_FIELD ][ $this->get_items_field() ];
    }
    
    
}