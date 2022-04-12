<?php 
/**
 * Template loader for Feedback Form Plugin.
 *
 * Only need to specify class properties here.
 *
 */
class WPC_Feedback_Form_Template_Loader extends Gamajo_Template_Loader {
 	
	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'feedback_form';
 
	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'feedback-form';
 
	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = FEEDBACK_FORM_DIR.'/public';
 
}
 ?>
