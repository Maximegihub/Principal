<?php
namespace Phox_Host\Builder;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

/**
 * Theme Builder Post Type
 *
 * Register and configure theme builder post type
 *
 * @package Builder
 * @since 2.0.0
 */
class Post_Type {

    /**
     * Template type arg for URL
     * @var string
     */
    public $type_tax = 'wdes_library_type';

    /**
     * Post type slug.
     *
     * @var string
     */
    public $slug = 'wdes-theme-builder';

    /**
     * Taps
     *
     * @var array
     */
    private $tabs = [];

    /**
     * Constructor for the class
     */
    public function __construct() {

        $init_structures = new Structures();

        $this->tabs = $init_structures->get_structures_for_post_type();

        add_action( 'init', [$this, 'register_builder'] , 0);

        if ( is_admin() ) {
            add_action( 'admin_menu', [$this, 'add_builder_page'], 23 );
        }

        add_filter( 'views_edit-' . $this->slug, array( $this, 'print_type_tabs' ) );

        add_action( 'admin_action_wdes_create_new_template', array( $this, 'create_template' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'template_type_form_assets' ) );

        add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'set_post_columns' ) );

        add_action( 'manage_' . $this->slug . '_posts_custom_column', array( $this, 'post_columns' ), 10, 2 );

    }

    /**
     * Register templates post type
     *
     * @since 2.0.0
     * @return void
     */
    public function register_builder(){

        $args = array(
            'labels' => array(
                'name'               => esc_html__( 'Header & Footer', 'phox-host' ),
                'singular_name'      => esc_html__( 'Template', 'phox-host' ),
                'add_new'            => esc_html__( 'Add New', 'phox-host' ),
                'add_new_item'       => esc_html__( 'Add New Template', 'phox-host' ),
                'edit_item'          => esc_html__( 'Edit Template', 'phox-host' ),
                'new_item'           => esc_html__( 'Add New Template', 'phox-host' ),
                'view_item'          => esc_html__( 'View Template', 'phox-host' ),
                'search_items'       => esc_html__( 'Search Template', 'phox-host' ),
                'not_found'          => esc_html__( 'No Templates Found', 'phox-host' ),
                'not_found_in_trash' => esc_html__( 'No Templates Found In Trash', 'phox-host' ),
                'menu_name'          => esc_html__( 'My Library', 'phox-host' ),
            ),
            'public'              => true,
            'hierarchical'        => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'exclude_from_search' => true,
            'capability_type'     => 'post',
            'rewrite'             => false,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'author', 'elementor' ),
        );

        register_post_type(
            $this->slug(),
            $args
        );

        $tax_args = array(
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'query_var'         => is_admin(),
            'rewrite'           => false,
            'public'            => false,
            'label'             => __( 'Type', 'phox-host' ),
        );

        register_taxonomy(
            $this->type_tax,
            $this->slug(),
            $tax_args
        );

    }

    /**
     * add builder to admin menu
     *
     * @since 2.0.0
     * @return void
     */
    public function add_builder_page() {

        add_submenu_page(
            'phox',
            esc_html__( 'Header & Footer', 'phox-host' ),
            esc_html__( 'Header & Footer', 'phox-host' ),
            'edit_pages',
            'edit.php?post_type=' . $this->slug()
        );

    }

    /**
     * Print library types tabs
     *
     * @return [type] [description]
     */
    public function print_type_tabs( $edit_links ) {


        $tabs = array_merge(
            [
                'all' => esc_html__( 'All', 'phox-host' ),
            ],
            $this->tabs
        );

        $active_tab = $_GET[$this->type_tax] ?? 'all';
        $page_link  = admin_url( 'edit.php?post_type=' . $this->slug() );

        if ( ! array_key_exists( $active_tab, $tabs ) ) {
            $active_tab = 'all';
        }

        print ( '<div class="nav-tab-wrapper wdes_library_type">' );

            foreach ( $tabs as $tab => $label ) {

                $class = 'nav-tab';

                if ( $tab === $active_tab ) {
                    $class .= ' nav-tab-active';
                }

                if ( 'all' !== $tab ) {
                    $link = add_query_arg( array( $this->type_tax => $tab ), $page_link );
                } else {
                    $link = $page_link;
                }

                printf( '<a href="%1$s" class="%3$s">%2$s</a>', $link, $label, $class );

            }

        print ( '</div>' );

        print ('<br>');

        return $edit_links;
    }

    /**
     * Templates post type slug
     *
     * @return string
     */
    public function slug() {
        return $this->slug;
    }

    /**
     * Template type popup assets
     *
     * @return void
     */
    public function template_type_form_assets() {

        $screen = get_current_screen();

        if ( $screen->id !== 'edit-' . $this->slug ) {
            return;
        }

        wp_enqueue_script(
            'wdes-templates-type-form-script',
            Phox_HOST_URI . '/assets/js/templates-type.js' ,
            ['jquery'],
            Phox_HOST_VERSION,
            true
        );

        wp_enqueue_style(
            'wdes-templates-type-form-style',
            Phox_HOST_URI . '/assets/css/templates-type.css',
            [],
            Phox_HOST_VERSION
        );

        add_action( 'admin_footer', array( $this, 'print_template_types_popup' ), 999 );

    }

    /**
     * Print template type form HTML
     *
     * @return void
     */
    public function print_template_types_popup() {

        $default_option = array(
            '' => esc_html__( 'Select...', 'phox-host' )
        );

        $template_types = $default_option + $this->tabs;
        $selected       = $_GET[$this->type_tax] ?? '';

        $action = add_query_arg(
            [
                'action' => 'wdes_create_new_template',
            ],
            esc_url( admin_url( 'admin.php' ) )
        );

        print( '<div class="wdes-template-types-popup">' );

            print ( '<div class="wdes-template-types-popup-overlay"></div>' );

            print ( '<div class="wdes-template-types-popup-content">' );

                printf ( '<h3 class="wdes-template-types-popup-heading"> %s </h3>', esc_html__( 'Select Template Type', 'phox-host' ) );

                printf ( '<form class="wdes-template-types-popup-form" id="templates_type_form" method="POST" action="%s" >', esc_url( $action ) );

                    print ( '<div class="wdes-template-types-popup-form-row">' );

                        printf ( '<label for="template_type">%s</label>', esc_html__( 'Select Type:', 'phox-host' ) );

                        print ( '<select id="template_type" name="template_type">' );

                            foreach ( $template_types as $type => $label ) {

                                printf( '<option value="%1$s" %3$s>%2$s</option>', $type, $label, selected( $selected, $type, false ) );

                            }

                        print ( '</select>' );

                    print ( '</div>' );

                    print ( '<div class="wdes-template-types-popup-form-row">' );

                        printf( '<label for="template_name">%s</label>', esc_html__( 'Template Name:', 'phox-host' ) );

                        printf( '<input type="text" id="template_name" name="template_name" placeholder="%s">', esc_html__( 'Set template name', 'phox-host' ) );

                    print ( '</div>' );

                    print ( '<div class="wdes-template-types-popup-form-actions">' );

                        printf ( '<button type="button" id="templates_type_submit" class="button button-primary button-hero">%s</button>', esc_html__( 'Create Template', 'phox-host' ) );

                    print ( '</div>' );

                print ( '</form>' );

            print ( '</div>' );

        print ( '</div>' );
    }

    /**
     * Create new template
     *
     * @return [type] [description]
     */
    public function create_template() {

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_die(
                esc_html__( 'You don\'t have permissions to do this', 'phox-host' ),
                esc_html__( 'Error', 'phox-host' )
            );
        }

        $type = isset( $_REQUEST['template_type'] ) ? esc_attr( $_REQUEST['template_type'] ) : false;

        if ( ! $type || ! array_key_exists( $type, $this->tabs ) ) {
            wp_die(
                esc_html__( 'Incorrect template type. Please try again.', 'phox-host' ),
                esc_html__( 'Error', 'phox-host' )
            );
        }

        $documents = \Elementor\Plugin::instance()->documents;
        $doc_type  = $documents->get_document_type( $type );

        if ( ! $doc_type ) {
            wp_die(
                esc_html__( 'Incorrect template type. Please try again.', 'phox-host' ),
                esc_html__( 'Error', 'phox-host' )
            );
        }

        $post_data = array(
            'post_type'  => $this->slug,
            'meta_input' => array(
                '_elementor_edit_mode' => 'builder',
            ),
            'tax_input'  => array(
                $this->type_tax => $type,
            ),
            'meta_input' => array(
                $doc_type::TYPE_META_KEY   => $type,
                '_elementor_page_settings' => [],
            ),
        );

        $title = isset( $_REQUEST['template_name'] ) ? esc_attr( $_REQUEST['template_name'] ) : '';

        if ( $title ) {
            $post_data['post_title'] = $title;
        }

        $template_id = wp_insert_post( $post_data );

        if ( ! $template_id ) {
            wp_die(
                esc_html__( 'Can\'t create template. Please try again', 'phox-host' ),
                esc_html__( 'Error', 'phox-host' )
            );
        }

        if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '<' ) ) {
            $redirect = \Elementor\Utils::get_edit_link( $template_id );
        } else {
            $redirect = \Elementor\Plugin::$instance->documents->get( $template_id )->get_edit_url();
        }

        wp_redirect( $redirect );
        die();

    }

    /**
     * Set required post columns
     *
     * @param array $columns
     * @return array
     */
    public function set_post_columns(array $columns ): array {

        unset( $columns['taxonomy-' . $this->type_tax ] );
        unset( $columns['date'] );

        $columns['type'] = __( 'Type', 'phox-host' );


        $columns['date'] = __( 'Date', 'phox-host' );


        return $columns;

    }

    /**
     * Manage post columns content
     *
     * @param string $column
     * @param int $post_id
     * @return void
     */
    public function post_columns(string $column , int $post_id): void {

        $init_structures = new Structures();

        $structure = $init_structures->get_post_structure( $post_id );

        switch ( $column ) {

            case 'type':

                if ( $structure ) {

                    $link = add_query_arg( array(
                        $this->type_tax => $structure['id'],
                    ) );

                    printf( '<a href="%1$s">%2$s</a>', $link, $structure['single_label'] );

                }

            break;

        }

    }

}