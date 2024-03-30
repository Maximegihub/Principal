<?php
/**
 * Ads Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */

class Wdes_Ads extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_wdes_Ads',
			'description' => esc_html__( 'Ads widget', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_ads', esc_html__( 'WHMCSDES Ads', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_ads';
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
		$title     = esc_attr( $instance['title'] );
		$ads_sizes = esc_attr( $instance['ads_sizes'] );
		$ads_img   = esc_url( $instance['ads_img'] );
		$ads_url   = esc_url( $instance['ads_url'] );

		// The Url is empty.
		if ( ! empty( $ads_url ) ) {
			$url_status = 'href=' . $ads_url . '';
		} else {
			$url_status = 'onclick="return false;"';
		}

		echo '<div class="block-sidebar-function wdes-ads-block">';
		if ( ! empty( $title ) ) {
			echo '<div class="wid-title">';
				echo '<h2>' . esc_html( $title ) . '</h2>';
			echo '</div>';
		}
		if ( ! empty( $ads_img ) ) {
			if ( 'ads' === $ads_sizes ) {
				echo '<a target="_blank" ' . esc_attr( $url_status ) . '>';
					echo '<img class="ads wdes-banner-280" src="' . esc_url( $ads_img ) . '" alt="'.esc_attr__('Ads', 'phox-host').'">';
				echo '</a>';
			} else {
				echo '<div class="ads-t-b">';
					echo '<a target="_blank" ' . esc_attr( $url_status ) . '>';
						echo '<img class="ads-tb wdes-banner-280" src="' . esc_url( $ads_img ) . '" alt="'.esc_attr__('Ads', 'phox-host').'">';
					echo '</a>';
				echo '</div>';
			}
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

		$instance ['title']     = strip_tags( $new_instance['title'] );
		$instance ['ads_sizes'] = strip_tags( $new_instance['ads_sizes'] );
		$instance ['ads_img']   = strip_tags( $new_instance['ads_img'] );
		$instance ['ads_url']   = strip_tags( $new_instance['ads_url'] );

		return $instance;

	}

	/**
	 * Outputs the settings updata form.
	 *
	 * @param array $instance Current settings.
	 * @return string
	 */
	public function form( $instance ) {
		$default  = array(
			'title'     => esc_html__( 'Advertisement', 'phox-host' ),
			'ads_sizes' => 'ads',
		);
		$instance = wp_parse_args( (array) $instance, $default );

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$ads_sizes = isset( $instance['ads_sizes'] ) ? esc_attr( $instance['ads_sizes'] ) : 'ads';
		$ads_img   = isset( $instance['ads_img'] ) ? esc_url( $instance['ads_img'] ) : '';
		$ads_url   = isset( $instance['ads_url'] ) ? esc_url( $instance['ads_url'] ) : '';

		// Ads Size.
		$ads_size = array(
			'ads'    => esc_html__( 'Ads 280 x 250 ', 'phox-host' ),
			'ads-tb' => esc_html__( 'Ads 280 x 90', 'phox-host' ),
		);

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ads_sizes' ) ); ?>"><?php esc_html_e( 'ads_sizes', 'phox-host' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'ads_sizes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ads_sizes' ) ); ?>" class="widefat">
				<?php foreach ( $ads_size as $option => $text ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $ads_sizes, $option ); ?>><?php echo esc_attr( $text ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ads_img' ) ); ?>"><?php esc_html_e( 'Image URL', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'ads_img' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ads_img' ) ); ?>" type="text" value="<?php echo esc_url( $ads_img ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ads_url' ) ); ?>"><?php esc_html_e( 'Ad URL', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'ads_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ads_url' ) ); ?>" type="text" value="<?php echo esc_url( $ads_url ); ?>" class="widefat" />
		</p>

		<?php
	}
}
