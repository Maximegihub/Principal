<?php
namespace Phox_Host\Elementor\Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}


/**
 * Walker class
 *
 * @since 2.0.0
 */
class Nav_walker_class extends \Walker_Nav_Menu {

	protected $active_megamenu  = false;
	protected $megamenu_col_num = 1;
	protected $megamenu_type = 'normal';

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes     = array( 'wdes-nav-sub', 'dropdown-content', ' wdes-global-style' );

		if( $this->active_megamenu  && 0 === $depth){
			$classes[] = 'mega-w';
		}


		if( $this->active_megamenu  && 0 >= $depth && $this->megamenu_type === 'template' ){
			$classes[] = 'd-none';
		}

		$classes[]   = 'wdes-nav-depth-' . $depth;
		$class_names = join( ' ', $classes );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<div $class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</div>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'wdes-nav-item-' . $item->ID;
		$classes[] = 'wdes-nav-item';

		//check if the root element is megamenu
		if( 0 === $depth){
			if($this->active_megamenu = get_post_meta( $item->ID, '_menu_item_mega', true ) ){
				$this->megamenu_col_num = get_post_meta( $item->ID, '_menu_item_col_num', true );
				$this->megamenu_type = get_post_meta( $item->ID, '_menu_item_mega_type', true );
				$classes[] ='mega menu-item-has-children';
			};
		}

		//check if item has children
		$has_children = $args->walker->has_children;

		if( $has_children || 'template' === $this->megamenu_type ){
			$classes[] ='wdes-dropdown';
		}

		if( $this->active_megamenu  && 1 === $depth){
			$classes[] = 'wdes-col';
			$classes[] = 'wdes-col-' . $this->megamenu_col_num;
			$classes[] = 'heading';
		}
		if ( 0 < $depth ) {
			$classes[] = 'wdes-nav-item-sub';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', array_filter( $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= $indent . '<div' . $class_names .'>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['class']  = 'menu-item-link menu-item-link-depth-' . $depth;

		if ( 0 === $depth ) {
			$atts['class'] .= ' menu-item-link-top';
		} else {
			$atts['class'] .= ' menu-item-link-sub';
		}

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$icon_align     =  $this->get_field_value( $item->ID, 'icon_align' );
		$icon_name      =  $this->get_field_value( $item->ID, 'icon' );
		$sec_text       =  $this->get_field_value( $item->ID, 'sec_text' );
		$sidebar_name   = '';
		$icon_color     = $this->get_field_value( $item->ID, 'icon_color' );
		$label          = $this->get_field_value( $item->ID, 'item_label' );
		$label_color    = $this->get_field_value( $item->ID, 'label_color' );
		$label_bg_color = $this->get_field_value( $item->ID, 'label_bg_color' );
		if($this->megamenu_type){
			$sidebar_name = $this->get_field_value($item->ID, 'mega_widgets');
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$title = sprintf( '<span class="wdes-nav-link-text">%s</span>', $title );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;

		//The content that will use in all cases like icon and label and Secondary
		// Text this options is run in general

		/* Icon Color */
		$item_icon_color = ( ! empty($icon_color) ) ? 'style="color:'.$icon_color.'"' : '' ;
		$item_icon = $icon_name ? sprintf('<span class="wdes-menu-icon wdes-menu-align-%2$s %1$s" %3$s ></span>',$icon_name, $icon_align, $item_icon_color) : '';

		/* Label */
		$item_label_color = ( ! empty($label) ) ? 'color:'.$label_color.';' : '' ;
		$item_label_bg_color = ( ! empty($label) ) ? 'background:'.$label_bg_color.';' : '' ;
		$item_label = $label ? sprintf('<span class="wdes-menu-label" style="%2$s %3$s" >%1$s</span>',$label, $item_label_color,$item_label_bg_color) : '';

		/* Secondary Text */
		$item_content = '';
		if( !empty($sec_text) && 1 === $depth && $this->active_megamenu ){
			$item_content = sprintf( '<span class="wdes-menu-sec-text" >%s</span>', $sec_text );
		}


		if( $this->active_megamenu && 'with_widget' === $this->megamenu_type  && 1 === $depth){

			if (is_active_sidebar($sidebar_name) && $sidebar_name !== 'wp_inactive_widgets' ) {
				ob_start();
				dynamic_sidebar($sidebar_name);
				$item_output .= ob_get_contents();
				ob_end_clean();
			}
		}elseif ($this->active_megamenu && 'template' === $this->megamenu_type  && 0 === $depth){

			//get the value of the mega menu option from backend
			//use str_replace to remove the prefix and keep only id
			$template_id = str_replace('te-','',$this->get_field_value( $item->ID, 'mega_template'));

			//the menu item html element.this is the parent not the children
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . $title . $args->link_after;


			if(  empty( $item_icon )  ){

				if ( in_array( 'menu-item-has-children', $item->classes ) ) {
					$top_arrow_icon = isset( $args->widget_settings['dropdown_icon'] ) ? $args->widget_settings['dropdown_icon'] : '<i class="fa fa-angle-down"></i>';
					$sub_arrow_icon = isset( $args->widget_settings['dropdown_icon_sub'] ) ? $args->widget_settings['dropdown_icon_sub'] : '<i class="fa fa-angle-right"></i>';

					$arrow_icon = ( 0 === $depth ) ? $top_arrow_icon : $sub_arrow_icon;

					if ( $arrow_icon ) {
						$item_output .= $this->get_dropdown_arrow_html( $arrow_icon ) . $item_label ;
					}
				}

			}else{
				$item_output .= $this->get_dropdown_arrow_html($item_icon) . $item_label ;
			}

			$item_output .= '</a>';
			$item_output .= $item_content ;
			$item_output .= $args->after;

			//get the elementor template by id
			//the template will generate the full html element
			$item_output .= $this->get_megamenu_template($template_id);


		}else{

			//normal menu item
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . $title . $args->link_after;

			if(  empty( $item_icon )  ){

				if ( in_array( 'menu-item-has-children', $item->classes ) ) {
					$top_arrow_icon = isset( $args->widget_settings['dropdown_icon'] ) ? $args->widget_settings['dropdown_icon'] : '<i class="fa fa-angle-down"></i>';
					$sub_arrow_icon = isset( $args->widget_settings['dropdown_icon_sub'] ) ? $args->widget_settings['dropdown_icon_sub'] : '<i class="fa fa-angle-right"></i>';

					$arrow_icon = ( 0 === $depth ) ? $top_arrow_icon : $sub_arrow_icon;

					if ( $arrow_icon ) {
						$item_output .= $this->get_dropdown_arrow_html( $arrow_icon ) . $item_label ;
					}
				}

			}else{
				$item_output .= $this->get_dropdown_arrow_html($item_icon) . $item_label ;
			}


			$item_output .= '</a>';
			$item_output .= $item_content ;
			$item_output .= $args->after;

		}

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Render Icon HTML
	 *
	 * @param  string $icon Icon slug to render.
	 * @return string
	 */
	public function get_dropdown_arrow_html( $icon = '' ) {

		return sprintf( '<div class="wdes-nav-arrow">%s</div>', htmlspecialchars_decode( $icon ) );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$output .= "</div>{$n}";
	}

	/**
	 * Get All Fields values
	 *
	 * get value option in menu backend
	 *
	 * @param $item_id
	 * @param $field_name
	 * @return string
	 */
	public function get_field_value( $item_id, $field_name ){
		return get_post_meta( $item_id, '_menu_item_' . $field_name, true );
	}


	/**
	 * Get mega menu from elementor template
	 *
	 * get the id then get the shortcode to get the full template and return the content
	 *
	 * @param $id integer template id
	 * @return string
	 */
	public function get_megamenu_template($id){

		$content = $this->elementor()->frontend->get_builder_content_for_display( $id );

		return '<ul class="wdes-nav-sub dropdown-content mega-w wdes-template-style" ><li>'.$content.'</li></ul>';
	}

	/**
	 * Instance Elementor
	 *
	 * @return mixed
	 */
	protected function elementor(){
		return \Elementor\Plugin::$instance;
	}

}