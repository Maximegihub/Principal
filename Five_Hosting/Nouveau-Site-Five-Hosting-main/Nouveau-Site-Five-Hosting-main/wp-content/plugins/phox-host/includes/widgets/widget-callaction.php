<?php
/**
 * Call To Action Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */

class Wdes_Call_To_Action extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_wdes_call_to_action',
			'description' => esc_html__( 'Call To Action widget', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_call_to_action', esc_html__( 'WHMCSDES Call To Action', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_call_to_action';
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

		echo '<div class="widget-call-to-action-button">';

		echo '<div class="wid-title">';

		if ( ! empty( $instance['title'] ) ) {
			echo '<h2>' . esc_html( $instance['title'] ) . '</h2>';

		} else {
			echo '<h2>' . esc_html__( 'Call To Action', 'phox-host' ) . '</h2>';
		}

		echo '</div>';

		if ( ! empty( $instance['description'] ) ) {
			echo '<h6>';
				echo esc_html( $instance['description'] );
			echo '</h6>';
		}

		if ( ! empty( $instance['button_url'] ) ) {
			$href = $instance['button_url'];
		} else {
			$href = '#';
		}

		if ( ! empty( $instance['button_title'] ) ) {
			echo '<a href="' . esc_url( $href ) . '"  class="job-modernlyo" >' . esc_html( $instance['button_title'] ) . '</a>';
		}

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

		$instance ['title']        = strip_tags( $new_instance['title'] );
		$instance ['description']  = strip_tags( $new_instance['description'] );
		$instance ['button_title'] = strip_tags( $new_instance['button_title'] );
		$instance ['button_url']   = strip_tags( $new_instance['button_url'] );

		return $instance;

	}

	/**
	 * Outputs the settings updata form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form( $instance ) {
		$title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$description  = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
		$button_title = isset( $instance['button_title'] ) ? esc_attr( $instance['button_title'] ) : '';
		$button_url   = isset( $instance['button_url'] ) ? esc_url( $instance['button_url'] ) : '';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'phox-host' ); ?></label>
			<textarea rows="3" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" class="widefat" ><?php echo esc_textarea( $description ); ?></textarea>
		</p>

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'button_title' ) ); ?>"><?php esc_html_e( 'Button Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'button_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_title' ) ); ?>" type="text" value="<?php echo esc_attr( $button_title ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Button URL', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" type="text" value="<?php echo esc_url( $button_url ); ?>" class="widefat" />
		</p>

		<?php
	}
}
