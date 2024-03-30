<?php
/**
 * Newsletter Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */

class Wdes_Newsletter extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_wdes_newsletter',
			'description' => esc_html__( 'Newsletter widget', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_newsletter', esc_html__( 'WHMCSDES Newsletter', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_newsletter';
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

		echo '<div class="widget_wdes_newsletter">';

		echo '<div class="wid-title">';

		if ( ! empty( $instance['title'] ) ) {
			echo '<h2>' . esc_html( $instance['title'] ) . '</h2>';

		} else {
			echo '<h2>' . esc_html__( 'NewsLetter', 'phox-host' ) . '</h2>';
		}

		echo '</div>';

		if ( ! empty( $instance['description'] ) ) {
			echo '<p>';
			x_wdes()->wdes_get_text( $instance['description'] );
			echo '</p>';
		}

		if ( ! empty( $instance['mailChimp_url'] ) ) {
			echo '<form action="' . esc_url( $instance['mailChimp_url'] ) . '" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">';
				echo '<input class="required email email-news"  name="EMAIL"  type="email" placeholder="' . esc_attr__( 'email', 'phox-host' ) . '">';
				echo '<input class="button sub-news" type="submit" value="' . esc_attr__( 'Subscribe', 'phox-host' ) . '">';
			echo '</form>';
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

		$instance ['title']         = strip_tags( $new_instance['title'] );
		$instance ['description']   = strip_tags( $new_instance['description'] );
		$instance ['mailChimp_url'] = strip_tags( $new_instance['mailChimp_url'] );

		return $instance;

	}

	/**
	 * Outputs the settings updata form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form( $instance ) {
		$title         = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$description   = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
		$mailchimp_url = isset( $instance['mailChimp_url'] ) ? esc_attr( $instance['mailChimp_url'] ) : '';
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'mailChimp_url' ) ); ?>"><?php esc_html_e( 'MailChimp URL', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'mailChimp_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mailChimp_url' ) ); ?>" type="url" value="<?php echo esc_attr( $mailchimp_url ); ?>" class="widefat" />
		</p>


		<?php
	}
}
