<?php
namespace Phox_Host\Elementor\Controls;

use \Elementor\Plugin;
use \Elementor\Base_Data_Control;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Wdes select templates control
 *
 * A base control for load all local templates and get the id of the template to can use in shortcodes
 *
 * @package Elementor\Control
 * @since 1.4.0
 */
class Select_Templates extends Base_Data_Control {

	/**
	 * Get select templates control type.
	 *
	 * Retrieve the control type, in this case `select templates`.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'wdes-select-templates';
	}

	/**
	 * Get select templates control default settings.
	 *
	 * Retrieve the default settings of the select templates control. Used to return the
	 * default settings while initializing the select templates control.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {

		$templates =  Plugin::$instance->templates_manager->get_source('local')->get_items();

		if( ! empty($templates) && is_array($templates) ){
			array_unshift( $templates, ['template_id'=> 'select-template', 'title'=> 'Select Template'  ] );
        }

		return [
		    'default' => 'select-template',
            'label_block' => true,
			'templates' => $templates
		];
	}

	/**
	 * Render select templates control output in the editor.
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
        <# if(templates.length != 0 ) { #>
            <div class="elementor-control-field">
                <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
                <div class="elementor-control-input-wrapper">
                    <select id="<?php echo $control_uid; ?>" data-setting="{{{data.name}}}">
                        <#
                            var printTemplates = function( templs ) {
                                _.each( templs, function( templ ) { #>
                                    <option value="{{ templ['template_id'] }}">{{{ templ['title'] }}}</option>
                                <# });
                            }
                            printTemplates(templates);
                        #>
                    </select>
                </div>
            </div>

            <#
                var getTemplateSelect =  _.filter(templates, function(key){
                        return key.template_id === parseInt(data.controlValue);
                    }
                );
            #>

            <# if ( data.description ) { #>
                <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>

        <# }else { #>
            <div class="elementor-control-field">
                <p><?php echo esc_html__('There are no Templates ', 'phox-host')?></p>
            </div>
        <# } #>
		<?php
	}

}