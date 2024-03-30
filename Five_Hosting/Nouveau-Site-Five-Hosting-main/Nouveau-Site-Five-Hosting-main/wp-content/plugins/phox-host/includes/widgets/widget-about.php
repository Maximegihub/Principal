<?php
/**
 * About Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */
class Wdes_About extends WP_Widget {
	/**
	 * Whether or not the widget has been registered yet.
	 *
	 * @var bool
	 */
	protected $registered = false;

	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'  => 'widget_wdes_about ',
			'description' => esc_html__( 'Create card with all the information about your company', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_about', esc_html__( 'WHMCSDES About', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_about';
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
		$class = ( isset( $instance['custom_class'] ) ) ? esc_attr( $instance['custom_class'] ) : '';

		echo '<div class="about wdes-about-widget ' . $class . '">';
		if ( ! empty( $instance['image'] ) ) {
			echo '<img class="logo-footer" src="' . esc_url( $instance['image'] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
		}

		if ( ! empty( $instance['description'] ) ) {
			echo '<p>';
				x_wdes()->wdes_get_text( $instance['description'] );
			echo '</p>';
		}

				echo '<div class="company-sc">';
		if ( ! empty( $instance['map'] ) ) {
			echo '<div class="company-info-block">';
				echo '<img src="' . WDES_ASSETS_URI . '/img/icons/location.svg" alt="location">';
				echo '<span>';
					x_wdes()->wdes_get_text( $instance['map'] );
				echo '</span>';
			echo '</div>';
		}

		if ( ! empty( $instance['email'] ) ) {
			echo '<div class="company-info-block">';
				echo '<img src="' . WDES_ASSETS_URI . '/img/icons/mail.svg" alt="mail">';
				echo '<a href="mailto:' . esc_attr( $instance['email'] ) . '">';
					echo '<span>';
						x_wdes()->wdes_get_text( $instance['email'] );
					echo '</span>';
				echo '</a>';
			echo '</div>';
		}

		if ( ! empty( $instance['tel'] ) ) {
			echo '<div class="company-info-block">';
				echo '<img src="' . WDES_ASSETS_URI . '/img/icons/support.svg" alt="support">';
				echo '<span>';
					x_wdes()->wdes_get_text( $instance['tel'] );
				echo '</span>';
			echo '</div>';
		}
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

		$instance ['title']       = wp_strip_all_tags( $new_instance['title'] );
		$instance ['image']       = wp_strip_all_tags( $new_instance['image'] );
		$instance ['description'] = wp_strip_all_tags( $new_instance['description'] );
		$instance ['map'] = wp_strip_all_tags( $new_instance['map'] );
		$instance ['email'] = wp_strip_all_tags( $new_instance['email'] );
		$instance ['tel'] = wp_strip_all_tags( $new_instance['tel'] );
		$instance ['custom_class'] = wp_strip_all_tags( $new_instance['custom_class'] );

		return $instance;

	}

	/**
	 * Register all widget instance of this widget class
	 */
	public function _register() {
		parent::_register();

		if ( $this->registered ) {
			return;
		}

		$this->registered = true;
		
	}



	/**
	 * Outputs the settings updata form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form( $instance ) {
		$title       = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$image       = isset( $instance['image'] ) ? esc_attr( $instance['image'] ) : '';
		$description = isset( $instance['description'] ) ? esc_textarea( $instance['description'] ) : '';
		$map         = isset( $instance['map'] ) ? esc_attr( $instance['map'] ) : '';
		$email       = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
		$tel         = isset( $instance['tel'] ) ? esc_attr( $instance['tel'] ) : '';
		$class = isset( $instance['custom_class'] ) ? esc_attr( $instance['custom_class'] ) : '';

		?>
		<p class="wdes-about-widget-display">
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
		</p>
        <p class="wdes-about-widget-display">
            <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image', 'phox-host' ); ?></label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $image ); ?>" class="widefat">
        </p>

		<p class="wdes-about-widget-display">
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'phox-host' ); ?></label>
			<textarea rows="10" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" class="widefat" ><?php echo esc_textarea( $description ); ?></textarea>
		</p>

		<p class="wdes-about-widget-display">
			<label for="<?php echo esc_attr( $this->get_field_id( 'map' ) ); ?>"><?php esc_html_e( 'Map', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'map' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'map' ) ); ?>" type="text" value="<?php echo esc_attr( $map ); ?>" class="widefat" />
		</p>

		<p class="wdes-about-widget-display">
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" class="widefat" />
		</p>

		<p class="wdes-about-widget-display">
			<label for="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>"><?php esc_html_e( 'Tel', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tel' ) ); ?>" type="text" value="<?php echo esc_attr( $tel ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php esc_html_e( 'Custom Class', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $class ); ?>" class="widefat" />
		</p>

		<?php
	}
}
