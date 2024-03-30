<?php
/**
 * Posts Widget
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 */

class Wdes_Posts extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_wdes_posts',
			'description' => esc_html__( 'Posts widget', 'phox-host' ),
		);

		parent::__construct( 'widget_wdes_posts', esc_html__( 'WHMCSDES Posts', 'phox-host' ), $widget_ops );

		$this->alt_option_name = 'widget_wdes_posts';
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
		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$posts_order    = isset( $instance['posts_order'] ) ? esc_attr( $instance['posts_order'] ) : 'latest';
		$count_of_posts = isset( $instance['count_of_posts'] ) ? esc_attr( $instance['count_of_posts'] ) : 5;

		$query_args = array(
			'posts_per_page' => $count_of_posts,
			'offset'         => '',
			'order'          => $posts_order,
		);

		echo '<div class="block-sidebar-function wdes-posts-sec">';
			echo '<div class="wid-title">';
                if ( ! empty( $instance['title'] ) ) {
                    echo '<h2>' . esc_html( $instance['title'] ) . '</h2>';

                } else {
                    echo '<h2>' . esc_html__( 'Posts', 'phox-host' ) . '</h2>';
                }
			echo '</div>';

			echo '<div class="wid-body">';
				echo '<ul class="posts">';
					$query = new WP_Query( $query_args );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li>';
                                    echo '<div class="img-post-wrap" >';
                                    if(!empty(get_the_post_thumbnail_url())){
                                            echo x_wdes()->wdes_get_thumbnail_link( 'wdes-image-widget' );
                                    }
                                    echo '</div>';

                                    if( ! empty( get_the_title() ) ){

                                        $post_title = get_the_title();

                                    }else{

                                        $post_title = 'No Title';

                                    }

                                    echo '<div class="content-post-sc">';
                                        echo '<a href="' . get_the_permalink() . '">' . $post_title . '</a>';
                                        echo '<div class="date-post-wid">';
                                            echo '<span class="far fa-clock"></span>';
                                            echo '<span>' . get_the_date() . '</span>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</li>';
							}
						}
					wp_reset_postdata();
				echo '</ul>';
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

		$instance ['title']          = strip_tags( $new_instance['title'] );
		$instance ['posts_order']    = strip_tags( $new_instance['posts_order'] );
		$instance ['count_of_posts'] = strip_tags( $new_instance['count_of_posts'] );

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
			'title'          => esc_html__( 'Recent Posts', 'phox-host' ),
			'count_of_posts' => '5',
			'posts_order'    => 'latest',
		);
		$instance = wp_parse_args( (array) $instance, $default );

		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$posts_order    = isset( $instance['posts_order'] ) ? esc_attr( $instance['posts_order'] ) : 'latest';
		$count_of_posts = isset( $instance['count_of_posts'] ) ? esc_attr( $instance['count_of_posts'] ) : 5;

		// Post Order : Default.
		$post_order = array(
			'latest'   => esc_html__( 'Recent Posts', 'phox-host' ),
			'rand'     => esc_html__( 'Random Posts', 'phox-host' ),
			'modified' => esc_html__( 'Last Modified Posts', 'phox-host' ),
			'popular'  => esc_html__( 'Most Commented Posts', 'phox-host' ),
		);

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Posts Order', 'phox-host' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
				<?php foreach ( $post_order as $option => $text ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $posts_order, $option ); ?>><?php echo esc_attr( $text ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count_of_posts' ) ); ?>"><?php esc_html_e( 'Number of Posts', 'phox-host' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'count_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_of_posts' ) ); ?>" type="text" value="<?php echo esc_attr( $count_of_posts ); ?>" class="widefat" />
		</p>

		<?php
	}
}
