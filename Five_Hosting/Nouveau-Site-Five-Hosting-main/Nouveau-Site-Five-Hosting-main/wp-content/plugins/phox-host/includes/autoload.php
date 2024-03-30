<?php
namespace Phox_Host;

if ( !defined('ABSPATH') ){
	exit; //Exit if assessed directly
}

/**
 * Phox Host Autoloader
 *
 * Phox Host Autoloader handler class is responsible for loading the different classess
 * needed to run the plugin
 *
 * @package Phox_Host
 * @since 1.0.0
 */
class Autoloader{

	/**
	 * Classes map
	 *
	 * Map Phox Host classes to file names
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array Classes used by Phox Host
	 */

	private static $classes_map = [
		'Share_Button' => 'includes/blog/social-media.php',
		'Pin_Posts' => 'includes/blog/pin-posts.php',

		'Init_Widgets' => 'includes/widgets/init_widgets.php',

		'Author_Profile' => 'includes/functions/author-profile.php',

		'Init_Wpml_Elementor' => 'includes/wpml/init_wpml_elementor.php',
		'Widget_Type' => 'includes/wpml/elementor/widget_type.php',
		'Section_Header' => 'includes/wpml/elementor/section_header.php',
		'Forms' => 'includes/wpml/elementor/forms.php',
		'Forms_Loop' => 'includes/wpml/elementor/integrations/forms_loop.php',
		'Plans' => 'includes/wpml/elementor/plans.php',
		'Plan_Layout_One_Loop' => 'includes/wpml/elementor/integrations/plans/plan_layout_one_loop.php',
		'Plan_Layout_Two_Loop' => 'includes/wpml/elementor/integrations/plans/plan_layout_two_loop.php',
		'Plan_Layout_Table_Head_Loop' => 'includes/wpml/elementor/integrations/plans/plan_layout_table_head_loop.php',
		'Plan_Layout_Table_Body_Loop' => 'includes/wpml/elementor/integrations/plans/plan_layout_table_body_loop.php',
		'Plan_Layout_Table_Foot_Loop' => 'includes/wpml/elementor/integrations/plans/plan_layout_table_foot_loop.php',
		'Tabs' => 'includes/wpml/elementor/tabs.php',
		'Tabs_Layouts_Features_Loop' => 'includes/wpml/elementor/integrations/tabs/tabs_layouts_features_loop.php',
		'Tabs_Layouts_Plans_Heads_Loop' => 'includes/wpml/elementor/integrations/tabs/tabs_layouts_plans_heads_loop.php',
		'Tabs_Layouts_Plans_Loop' => 'includes/wpml/elementor/integrations/tabs/tabs_layouts_plans_loop.php',
		'Tabs_Layouts_Testimonial_Loop' => 'includes/wpml/elementor/integrations/tabs/tabs_layouts_testimonial_loop.php',
		'FAQ' => 'includes/wpml/elementor/faq.php',
		'FAQ_Loop' => 'includes/wpml/elementor/integrations/faq_loop.php',
		'Carousels' => 'includes/wpml/elementor/carousels.php',
		'Carousels_Layouts_Loop' => 'includes/wpml/elementor/integrations/carousels_layouts_loop.php',
		'Partners' => 'includes/wpml/elementor/partners.php',
		'Partners_Loop' => 'includes/wpml/elementor/integrations/partners_loop.php',
		'Features_Boxs' => 'includes/wpml/elementor/features_boxs.php',
		'Feature_Box_Layout_Loop' => 'includes/wpml/elementor/integrations/features/feature_box_layout_loop.php',
		'Feature_Info_Box_Icon_Layout_Loop' => 'includes/wpml/elementor/integrations/features/feature_info_box_icon_layout_loop.php',
		'Feature_Info_Box_Layout_Loop' => 'includes/wpml/elementor/integrations/features/feature_info_box_layout_loop.php',
		'Feature_Side_Layout_Loop' => 'includes/wpml/elementor/integrations/features/feature_side_layout_loop.php',
		'Breadcrumb' => 'includes/wpml/elementor/breadcrumb.php',
		'Breadcrumb_Loop' => 'includes/wpml/elementor/integrations/breadcrumb_loop.php',
		'App' => 'includes/wpml/elementor/app.php',
		'Button' => 'includes/wpml/elementor/button.php',
		'Alert' => 'includes/wpml/elementor/alert.php',
        'Price_Table' => 'includes/wpml/elementor/price_table.php',
        'Price_Table_Features_Loop' => 'includes/wpml/elementor/integrations/price_table_features_loop.php',
        'Testimonial' => 'includes/wpml/elementor/testimonial.php',
        'Testimonial_Items_Loop' => 'includes/wpml/elementor/integrations/testimonial_items_loop.php',
        'Dual_Button' => 'includes/wpml/elementor/dual_button.php',


		'Elementor\Core_Elementor' => 'includes/elementor/core_elementor.php',
		'Elementor\Base\Base_Widget' => 'includes/elementor/base/base_widget.php',
		'Elementor\Base\Base_Builder_Widget' => 'includes/elementor/base/base_builder_widget.php',
		'Elementor\Libs\Table\CSV_Parser' => 'includes/elementor/libs/table/csv_parser.php',
		'Elementor\Functions\Domain_Class' => 'includes/elementor/functions/domain/domain_class.php',
		'Elementor\Functions\Woo_Handler' => 'includes/elementor/functions/woo_cart/woo_handler.php',
		'Elementor\Functions\Map_Styles' => 'includes/elementor/functions/map/map_styles.php',


		'Builder\Structures' => 'includes/builder/structures.php',
		'Builder\Post_Type' => 'includes/builder/post_type.php',
	];

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function run() {
		
		spl_autoload_register( [ __CLASS__, 'autoload_files' ] );

	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {

		if ( isset( self::$classes_map[ $relative_class_name ] ) ) {
			$filename = Phox_HOST_PATH. '/' . self::$classes_map[ $relative_class_name ];
		} else {
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);
			
			$filename = Phox_HOST_PATH . $filename . '.php';

		}

		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload_files( $class ) {

		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );

		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;


		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}

	}

}