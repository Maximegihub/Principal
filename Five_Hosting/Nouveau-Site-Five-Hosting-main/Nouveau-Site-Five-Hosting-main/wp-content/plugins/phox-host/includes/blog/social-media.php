<?php
namespace Phox_Host;

if ( !defined('ABSPATH') ){
	exit; //Exit if assessed directly
}

/**
 * Share Social Button
 *
 * Share Social Button that will show in the single post
 *
 * @package Phox_Host
 * @since 1.0.0
 */
class Share_Button {

	/**
	 * Post Share Social
	 *
	 * Core of the class is in this function
	 *
	 * @param $is_social_active
	 */
	public static function post_share_social($is_social_active) {

		$post_link        = get_permalink();
		$post_title       = htmlspecialchars( urlencode( html_entity_decode( esc_attr( get_the_title() ), ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );

		$social_icons = array(
			'facebook'    => array(
				'url'  => 'https://www.facebook.com/sharer.php?u=' . $post_link,
				'text' => esc_html__( 'Facebook', 'phox-host' ),
			),
			'twitter'     => array(
				'url'  => 'https://twitter.com/intent/tweet?text=' . $post_title . '&amp;url=' . $post_link,
				'text' => esc_html__( 'Twitter', 'phox-host' ),
			),
			'reddit' => array(
				'url'  => 'https://reddit.com/submit?url=' . $post_link . '&title=' . $post_title,
				'text' => esc_html__( 'Reddit', 'phox-host' ),
			),
			'linkedin'    => array(
				'url'  => 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $post_link . '&amp;title=' . $post_title,
				'text' => esc_html__( 'LinkedIn', 'phox-host' ),
			),
			'pinterest'   => array(
				'url'  => 'http://pinterest.com/pin/create/button/?url=' . $post_link . '&amp;description=' . $post_title,
				'text' => esc_html__( 'Pinterest', 'phox-host' ),
			),

		);

		$output  = '<div class="share-blog">';
			$output .= '<ul>';
				foreach ( $social_icons as $key => $value ) {
					$icon        = empty( $value['icon'] ) ? $key : $value['icon'];
					$output     .= '<li>';
						$output .= '<a class="' . $key . '-bg-block" href="' . $value['url'] . '"><span class="fab fa-' . $icon . ' icon-share-post"></span>' . $value['text'] . '</a>';
					$output     .= '</li>';
				}
			$output .= '</ul>';
		$output .= '</div>';

		if ( is_null( $is_social_active ) ) {
			echo wp_kses_post($output);
		}

	}

}