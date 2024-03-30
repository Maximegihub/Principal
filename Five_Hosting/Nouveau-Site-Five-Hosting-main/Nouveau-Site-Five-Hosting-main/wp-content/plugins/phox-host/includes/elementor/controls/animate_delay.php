<?php
namespace Phox_Host\Elementor\Controls;

use \Elementor\Plugin;
use \Elementor\Base_Data_Control;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Wdes Animate Delay control
 *
 * A base control for load all animate delay
 *
 * @package Elementor\Control
 * @since 1.4.0
 */
class Animate_Delay extends Base_Data_Control {

	/**
	 * Get animate delay control type.
	 *
	 * Retrieve the control type, in this case `animate delay`.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'wdes-animate-delay';
	}

	/**
	 * Get animate delay control default settings.
	 *
	 * Retrieve the default settings of the animate delay control. Used to return the
	 * default settings while initializing the animate delay control.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {

		$delay = [
			'none'   => 'None',
			'delay-2s' => '2 Second' ,
			'delay-3s' => '3 Second',
			'delay-4s' => '4 Second',
			'delay-5s' => '5 Second'
		];

		return [
			'default' => 'none',
			'label_block' => true,
			'delays' => $delay
		];
	}

	/**
	 * Render animate delay control output in the editor.
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
						var printEffect = function( delays ) {
						_.each( delays, function( key, value  ) { #>
							<option value="{{ value }}">{{{ key }}}</option>
						<# });
						}
							printEffect(delays);
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