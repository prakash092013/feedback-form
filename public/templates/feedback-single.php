<?php 
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Feedback_Form
 * @subpackage Feedback_Form/public/partials
 */
?>
<div class="single-feedback">
    <p><label for="first_name"><?php esc_html_e('First Name', 'feedback-form'); ?>:</label> <?php echo esc_html($data->first_name); ?></p>
	<p><label for="first_name"><?php esc_html_e('Last Name', 'feedback-form'); ?>:</label> <?php echo esc_html($data->last_name); ?></p>
	<p><label for="first_name"><?php esc_html_e('Email', 'feedback-form'); ?>:</label> <?php echo esc_html($data->email); ?></p>
	<p><label for="first_name"><?php esc_html_e('Subject', 'feedback-form'); ?>:</label> <?php echo esc_html($data->subject); ?></p>
	<p><label for="first_name"><?php esc_html_e('Message', 'feedback-form'); ?>:</label> <?php echo esc_textarea($data->message); ?></p>
</div>
