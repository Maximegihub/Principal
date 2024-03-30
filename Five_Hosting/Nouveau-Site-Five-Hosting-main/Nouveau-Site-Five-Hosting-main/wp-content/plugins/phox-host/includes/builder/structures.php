<?php
namespace Phox_Host\Builder;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

/**
 * Theme Builder Structures
 *
 * Register theme builder sections
 *
 * @package Builder
 * @since 2.0.0
 */
class Structures {

    /**
     * structures data
     *
     * @var null
     */
    private $structures = null;

    public function __construct() {

        $this->register_structures();

        add_action( 'elementor/documents/register', array( $this, 'register_document_types_for_structures' ) );

    }

    /**
     * Register apropriate Document Types for existing structures
     *
     * @since 2.0.0
     * @return void
     */
    public function register_document_types_for_structures( $documents_manager ) {


        foreach ( $this->structures as $id => $structure ) {

            $document_type = $structure['document_properties'];

            require Phox_HOST_PATH . 'includes/builder/document-types/' . $document_type['file_name'];

            $documents_manager->register_document_type( $id, $document_type['class'] );

        }
    }

    /**
     * register structures
     *
     * @since 2.0.0
     * @return void
     */

    public function register_structures() {

        $structures =[
          $this->header_config(),
          $this->footer_config()
        ];

        foreach ( $structures as $config ) {

            $this->register_structure( $config );

        }

    }

    /**
     * register structure
     * use on `register_structures`
     *
     * @since 2.0.0
     * @return void
     */
    public function register_structure( $doc_type_config ){

        $this->structures[ $doc_type_config['id'] ]  = $doc_type_config;

    }

    /**
     * Get Structures For Post Type
     *
     * Return structures prepared for post type page tabs
     *
     * @since 2.0.0
     * @return array (id, single label) for all document types
     */
    public function get_structures_for_post_type() {

        $result = [];

        foreach ( $this->structures as $id => $structure ) {
            $result[ $id ] = $structure['single_label'];
        }

        return $result;

    }

    /**
     * Returns all structures data
     *
     * @return object
     */
    public function get_structure( $id ) {
        return $this->structures[$id] ?? false;
    }

    /**
     * Get post structure name for current post ID.
     *
     * @param  int $post_id Post ID
     * @return string
     */
    public function get_post_structure( $post_id ) {

        $doc_type = get_post_meta( $post_id, '_elementor_template_type', true );

        if ( ! $doc_type ) {
            return false;
        }

        $doc_structure = $this->get_structure( $doc_type );

        if ( ! $doc_structure ) {
            return false;
        } else {
            return $doc_structure;
        }

    }

    /**
     * Header Document type config
     *
     * @since 2.0.0
     * @return array
     */
    public function header_config() {

        $config = [
            'id' => 'wdes_header',
            'single_label' => esc_html__( 'Header', 'phox-host' ),
            'plural_label' => esc_html__( 'Header', 'phox-host' ),
            'document_properties' => [
                'class' => '\Phox_Host\Builder\Header_Document',
                'file_name' => 'header_document.php'
            ],


        ];

        return $config;

    }

    /**
     * Footer Document type config
     *
     * @since 2.0.0
     * @return array
     */
    public function footer_config(){

        $config = [
            'id' => 'wdes_footer',
            'single_label' => esc_html__( 'Footer', 'phox-host' ),
            'plural_label' => esc_html__( 'Footer', 'phox-host' ),
            'document_properties' => [
                'class' => '\Phox_Host\Builder\Footer_Document',
                'file_name' => 'footer_document.php'
            ],


        ];

        return $config;

    }

}