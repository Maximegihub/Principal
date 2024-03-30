<?php
namespace Phox_Host\Elementor\Controls;

use \Elementor\Plugin;
use \Elementor\Base_Data_Control;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Wdes Animate Speed control
 *
 * A base control for load all animate Speed
 *
 * @package Elementor\Control
 * @since 1.4.0
 */
class Animate_Speed extends Base_Data_Control {

	/**
	 * Get animate Speed control type.
	 *
	 * Retrieve the control type, in this case `animate Speed`.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'wdes-animate-speed';
	}

	/**
	 * Get animate Speed control default settings.
	 *
	 * Retrieve the default settings of the animate Speed control. Used to return the
	 * default settings while initializing the animate Speed control.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {

		$speed = [
			'none'   => 'None',
			'slower' => 'Slower',
			'slow'   => 'Slow' ,
			'fast'   => 'Fast',
			'faster' => 'Faster'
		];

		return [
			'default' => 'none',
			'label_block' => true,
			'speeds' => $speed
		];
	}

	/**
	 * Render animate Speed control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<select id="<?php echo $control_uid; ?>" data-setting="{{{data.name}}}">
					<#
						var printEffect = function( speeds ) {
						_.each( speeds, function( key, value  ) { #>
						<option value="{{ value }}">{{{ key }}}</option>
						<# });
							}
							printEffect(speeds);
							#>
				</select>
			</div>
		</div>


		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>

		<?php
	}

}