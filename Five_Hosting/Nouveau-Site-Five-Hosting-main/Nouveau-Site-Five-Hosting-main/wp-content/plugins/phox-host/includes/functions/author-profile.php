<?php
namespace Phox_Host;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Social Media For Author Profile
 *
 * Add Social Media url to the author profile
 *
 * @package Phox_Host
 * @since 1.3.0
 */
class Author_Profile {

	/**
	 * Author Profile construction
	 *
	 * initializing Author Profile
	 *
	 * @since  1.3.0
	 * @access public
	 */
	public function __construct()
	{
		add_action('show_user_profile', array($this, 'wdes_user_profile_options'));
		add_action('edit_user_profile', array($this, 'wdes_user_profile_options'));

		add_action('personal_options_update', array($this, 'wdes_save_user_profile_options'));
		add_action('edit_user_profile_update', array($this, 'wdes_save_user_profile_options'));
	}

	/**
	 * Author Social List.
	 *
	 * All social media names
	 *
	 * @since 1.3.0
	 * @access public
	 * @return array $social_list
	 */
	public static function wdes_author_social_array() {

		$social_list = array(
			'facebook'     =>array('name' => esc_html__('Facebook', 'phox-host')),
			'twitter'      =>array('name' => esc_html__('Twitter', 'phox-host')),
			'google'       =>array('name' => esc_html__('Google+', 'phox-host'), 'icon' => 'google-plus'),
			'linkedin'     =>array('name' => esc_html__('LinkedIn', 'phox-host')),
			'flickr'       =>array('name' => esc_html__('Flickr', 'phox-host')),
			'youtube'      =>array('name' => esc_html__('YouTube', 'phox-host')),
			'pinterest'    =>array('name' => esc_html__('Pinterest', 'phox-host')),
			'behance'      =>array('name' => esc_html__('Behance', 'phox-host')),
			'instagram'    =>array('name' => esc_html__('Instagram', 'phox-host')),
		);

		return $social_list;
	}

	/**
	 * Author Profile Template.
	 *
	 * Html template for author profile
	 *
	 * @since 1.3.0
	 * @access public
	 */
	public function wdes_user_profile_options($user)
	{?>

		<h3><?php esc_html_e('Social Media Account', 'phox-host'); ?></h3>
		<table class="form-table">
			<?php
			$author_social = $this::wdes_author_social_array();

			foreach ($author_social as $key => $value):
				?>
				<tr>
					<th><label for="<?php echo esc_attr($key) ?>"><?php echo esc_html($value['name']) ?></label></th>
					<td>
						<input type="text" name="<?php echo esc_attr($key) ?>" id="<?php echo esc_attr($key) ?>" value="<?php echo esc_attr(get_the_author_meta($key, $user->ID))  ?>" class="regular-text" /><br />
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

	<?php }

	/**
	 * Save Author Profile.
	 *
	 * All social media save and update by this function
	 *
	 * @since 1.3.0
	 * @access public
	 */
	public function wdes_save_user_profile_options($user_id)
	{

		if(! current_user_can('edit_user', $user_id)){
			return false;
		}

		update_user_meta($user_id, 'author_widget_content', $_POST['author_widget_content']);

		$author_social = $this::wdes_author_social_array();

		foreach ($author_social as $key => $value){

			update_user_meta( $user_id, $key, $_POST[ $key ] );

		}

	}

}