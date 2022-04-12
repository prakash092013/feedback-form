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
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php if( isset($data->title) && !empty($data->title) ): ?>
    <h2><?php esc_html_e('Submit your feedback', 'feedback-form'); ?></h1>
<?php endif; ?>
<fieldset class="CodeableFeedbackForm-wrapper">
    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" id="CodeableFeedbackForm" class="CodeableFeedbackForm" >

        <?php wp_nonce_field( 'codeable_form_submit-nonce' ); ?>
        <input type="hidden" name="action" value="codeable_form_submit" />
        <p>
            <label for="first_name"><?php esc_html_e('First name', 'feedback-form'); ?>:</label><br>
            <input type="text" id="first_name" name="first_name" value="<?php echo esc_html($data->first_name); ?>" />
        </p>

        <p>
            <label for="last_name"><?php esc_html_e('Last name', 'feedback-form'); ?>:</label><br>
            <input type="text" id="last_name" name="last_name" value="<?php echo esc_html($data->last_name); ?>" />
        </p>

        <p>
            <label for="email"><?php esc_html_e('Email', 'feedback-form'); ?>:</label><br>
            <input type="email" id="email" name="email" value="<?php echo esc_html($data->email); ?>" />
        </p>

        <p>
            <label for="subject"><?php esc_html_e('Subject', 'feedback-form'); ?>:</label><br>
            <input type="text" id="subject" name="subject" />
        </p>

        <p>
            <label for="message"><?php esc_html_e('Message', 'feedback-form'); ?>:</label><br>
            <textarea id="message" name="message"></textarea>
        </p>

        <p class="submit-section">
            <input class="button" type="reset" value="<?php esc_html_e('Clear', 'feedback-form'); ?>">&nbsp;
            <input class="button" type="submit" value="<?php esc_html_e('Submit', 'feedback-form'); ?>">
            <span class="spinner"></span>
        </p>
    </form>
    <div class="thankyou_message">
        <p><?php esc_html_e('Thank you for sending us your feedback', 'feedback-form'); ?>.&nbsp;<small><a href="javascript:window.location.reload(true)"><?php esc_html_e('Submit another feedback', 'feedback-form'); ?></a></small>.</p>
    </div>
</fieldset>
