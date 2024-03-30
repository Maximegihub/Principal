<?php
/**
 * This is the class that handles debugging functionalities
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Basepress_Debug_Output' ) ){

	class Basepress_Debug_Output{

		private $is_debug = false;

		function __construct(){
			add_action( 'init', array( $this, 'toggle_debugging' ) );
		}


		public function toggle_debugging(){

			if( isset( $_REQUEST['basepress_debug'] ) && ! (bool)$_REQUEST['basepress_debug'] && isset( $_COOKIE['basepress_debug'] ) ){
				$this->is_debug = false;
				setcookie( 'basepress_debug', true, time() - 3600, '/' );
			}
			elseif( isset( $_REQUEST['basepress_debug'] ) && (bool)$_REQUEST['basepress_debug']
				|| isset( $_COOKIE['basepress_debug'] ) ){
				$this->is_debug = true;
				setcookie( 'basepress_debug', true, 0, '/' );
				add_action( 'wp_footer', array( $this, 'run_debug' ) );
			}

		}

		public function run_debug(){
			global $basepress_utils;

			$options = $basepress_utils->get_options();
			?>
<!-- BasePress KB Debugging info

VERSION: <?php echo BASEPRESS_VER; ?>

DB VERSION: <?php echo BASEPRESS_DB_VER; ?>

PLAN: <?php echo ucfirst( BASEPRESS_PLAN ); ?>


VARIABLES:
<?php
global $basepress_utils;
echo 'is_knowledgebase: ' . var_export( $basepress_utils->is_knowledgebase, true ) . "\n";
echo 'is_products_page: ' . var_export( $basepress_utils->is_products_page, true ) . "\n";
echo 'is_product: ' . var_export( $basepress_utils->is_product, true ) . "\n";
echo 'is_section: ' . var_export( $basepress_utils->is_section, true ) . "\n";
echo 'is_tag: ' . var_export( $basepress_utils->is_tag, true ) . "\n";
echo 'is_article: ' . var_export( $basepress_utils->is_article, true ) . "\n";
echo 'is_search: ' . var_export( $basepress_utils->is_search, true ) . "\n";
echo 'is_global_search: ' . var_export( $basepress_utils->is_global_search, true ) . "\n";

//Exclude this options from output
$excluded_options = array(
	'post_count_ip_exclude',
	'feedback_recaptcha_site_key',
	'feedback_recaptcha_secrete_key',
	'feedback_notify_admin',
	'feedback_notice_email_from'
);

foreach( $excluded_options as $excluded_option ){
	if( isset( $options[$excluded_option] ) ){
		unset( $options[$excluded_option] );
	}
}
?>

OPTIONS:
<?php echo var_export( $options ); ?>

-->
<?php
		}
	}

	new Basepress_Debug_Output();
}
