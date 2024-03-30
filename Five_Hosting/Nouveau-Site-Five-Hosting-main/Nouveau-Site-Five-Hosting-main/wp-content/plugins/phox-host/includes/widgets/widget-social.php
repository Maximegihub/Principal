<?php
/**
 * Social Networks Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */

class Wdes_Social extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_wdes_Social',
			'description' => esc_html__( 'Social widget', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_social', esc_html__( 'WHMCSDES Social', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_social';
	}

	/**
	 * Echoes the widget content
	 *
	 * @param array $args Display arguments .
	 * @param array $instance The setting for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = null;
		}
		extract( $args, EXTR_SKIP );

		// Varubles.
		$title = esc_attr( $instance['title'] );
		$class = ( isset( $instance['custom_class'] ) ) ? esc_attr( $instance['custom_class'] ) : '';

		echo '<div class="block-sidebar-function wdes-socialmedia-widget '. $class .'">';
		if ( ! empty( $title ) ) {
			echo '<div class="wid-title">';
				echo '<h2>' . esc_html( $title ) . '</h2>';
			echo '</div>';
		}
			echo '<div class="wid-body">';
				do_action( 'wdes_header_social', 'socialmedia-icons', '' );
			echo '</div>';

		echo '</div>';

	}


	/**
	 * Update a particular instance of a widget
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance ['title'] = strip_tags( $new_instance['title'] );
		$instance ['custom_class'] = strip_tags( $new_instance['custom_class'] );

		return $instance;

	}

	/**
	 * Outputs the settings updata form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form( $instance ) {
		$default  = array( 'title' => esc_html__( 'social networks', 'phox-host' ), 'custom_class' => esc_html__( '', 'phox-host' ) );
		$instance = wp_parse_args( (array) $instance, $default );

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$class = isset( $instance['custom_class'] ) ? esc_attr( $instance['custom_class'] ) : '';

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
		</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php esc_html_e( 'Custom Class', 'phox-host' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $class ); ?>" class="widefat" />
        </p>

		<?php
	}
}
