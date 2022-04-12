<?php
/**
 * Plugin Name: Feedback Form
 * Description: A feedback form to collect customers feedback.
 * Plugin URI:  https://wordpresscapital.com
 * Version:     1.0.0
 * Author:      Prakash Rao
 * Author URI:  https://wordpresscapital.com
 * Text Domain: codeable-feedback-form
 * Domain Path: /languages
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Plugin version.
 */
define( 'FEEDBACK_FORM_VERSION', '1.0.0' );
define( 'FEEDBACK_FORM_DIR', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-feedback-form-activator.php
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-feedback-form-activator.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-feedback-form-deactivator.php';


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-feedback-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_codeable_feedback_form() {

    $plugin = new WPC_Feedback_Form();
    $plugin->run();

}
run_codeable_feedback_form();
