<?php
namespace Phox_Host\Elementor\Controls;

use Elementor\Base_Data_Control;
use Elementor\Plugin;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Wdes Animate Effect control
 *
 * A base control for load all animate library effects
 *
 * @package Elementor\Control
 * @since 1.4.0
 */
class Animate_Effect extends Base_Data_Control {

	/**
	 * Get animate effect control type.
	 *
	 * Retrieve the control type, in this case `animate effect`.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'wdes-animate-effect';
	}

	/**
	 * Get animate effect control default settings.
	 *
	 * Retrieve the default settings of the animate effect control. Used to return the
	 * default settings while initializing the animate effect control.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {

		$effects = [
			'bounce' ,
			'flash' ,
			'pulse' ,
			'rubberBand',
			'shake' ,
			'headShake' ,
			'swing' ,
			'tada'  ,
			'wobble' ,
			'jello' ,
			'bounceIn' ,
			'bounceInDown'  ,
			'bounceInLeft'  ,
			'bounceInRight' ,
			'bounceInUp' ,
			'bounceOut' ,
			'bounceOutDown' ,
			'bounceOutLeft' ,
			'bounceOutRight' ,
			'bounceOutUp' ,
			'fadeIn' ,
			'fadeInDown' ,
			'fadeInDownBig' ,
			'fadeInLeft' ,
			'fadeInLeftBig' ,
			'fadeInRight' ,
			'fadeInRightBig' ,
			'fadeInUp' ,
			'fadeInUpBig' ,
			'fadeOut' ,
			'fadeOutDown' ,
			'fadeOutDownBig' ,
			'fadeOutLeft' ,
			'fadeOutLeftBig' ,
			'fadeOutRight' ,
			'fadeOutRightBig' ,
			'fadeOutUp' ,
			'fadeOutUpBig' ,
			'flipInX' ,
			'flipInY' ,
			'flipOutX' ,
			'flipOutY' ,
			'lightSpeedIn' ,
			'lightSpeedOut' ,
			'rotateIn',
			'rotateInDownLeft',
			'rotateInDownRight',
			'rotateInUpLeft',
			'rotateInUpRight',
			'rotateOut',
			'rotateOutDownLeft',
			'rotateOutDownRight',
			'rotateOutUpLeft',
			'rotateOutUpRight',
			'hinge',
			'jackInTheBox',
			'rollIn',
			'rollOut',
			'zoomIn',
			'zoomInDown',
			'zoomInLeft',
			'zoomInRight',
			'zoomInUp',
			'zoomOut',
			'zoomOutDown',
			'zoomOutLeft',
			'zoomOutRight',
			'zoomOutUp',
			'slideInDown',
			'slideInLeft',
			'slideInRight',
			'slideInUp',
			'slideOutDown',
			'slideOutLeft',
			'slideOutRight',
			'slideOutUp',
			'heartBeat'
		];

		return [
			'default' => 'fadeIn',
			'label_block' => true,
			'effects' => $effects
		];
	}

	/**
	 * Render animate effect control output in the editor.
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
				<select class="wdes-animate-control" id="<?php echo $control_uid; ?>" data-setting="{{{data.name}}}">
					<#
						var printEffect = function( effects ) {
                            _.each( effects, function( effect  ) { #>
                            <option value="{{ effect }}">{{{ effect }}}</option>
                            <# });
                        }
                        printEffect(effects);
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