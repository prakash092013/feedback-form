<?php 
/*
 * Class for Handling the Form related operations
*/
class WPC_Feedback_Form_Handler extends WPC_Feedback_Form_Template_Loader {

	public function __construct() {
		// Frontend form submit fallback handler
		add_action(
			'wp_ajax_codeable_form_submit',
			array( $this, 'codeable_form_submit_cb' )
		);
		add_action(
			'wp_ajax_nopriv_codeable_form_submit',
			array( $this, 'codeable_form_submit_cb' )
		);

		// register Form Shortcode
		add_shortcode( 'feedback-form', array( $this, 'feedback_form_shortcode_cb' ) );
	}

	public function feedback_form_shortcode_cb( $atts ){

		// get current user data if logged in
		if( is_user_logged_in() ){
			$user = wp_get_current_user();
		}

		// shortcode attributes
		$attributes = shortcode_atts( array(
	        'title' 		=> true,
	        'guest' 		=> true,
	    ), $atts );

		// user data
	    $userdata = array(
	    	'first_name' 	=> is_user_logged_in() ? $user->user_firstname : '',
			'last_name' 	=> is_user_logged_in() ? $user->user_lastname : '',
			'email' 		=> is_user_logged_in() ? $user->user_email : ''
	    );

	    // final data for template file
	    $final_atts = array_merge($attributes, $userdata);
	    $this->set_template_data( $final_atts );
	    ob_start();
	 	$this->get_template_part( 'feedback', 'form' );
	 	return ob_get_clean();
	}

	/* Shortcode for handling for submissions */
	public function codeable_form_submit_cb(){
		
		// verify nonce
		check_ajax_referer( 'codeable_form_submit-nonce' );

		// perform server side validations
		$errors = [];
		if( !isset($_POST['first_name']) || empty($_POST['first_name']) ){
			$errors['first_name'] = "Please enter first name.";
		}

		if( !isset($_POST['last_name']) || empty($_POST['last_name']) ){
			$errors['last_name'] = "Please enter last name.";
		}

		if( !isset($_POST['email']) || empty($_POST['email']) ){
			$errors['email'] = "Please enter email.";
		} else{
			// check if valid email
			if( !is_email($_POST['email']) ){
				$errors['email'] = "Please enter a valid email.";
			}
		}

		if( !isset($_POST['subject']) || empty($_POST['subject']) ){
			$errors['subject'] = "Please enter subject.";
		}

		if( !isset($_POST['message']) || empty($_POST['message']) ){
			$errors['message'] = "Please enter your message.";
		}

		// check if errors and return them
		if( isset($errors) && count($errors) > 0 ){
			wp_send_json_error($errors);
		} else{
			global $wpdb;
			$feedback_args = array(
			    'post_title'   	=> sanitize_text_field(time().' : Feedback from '.$_POST['email']),
			    'post_type' 	=> 'feedback',
			    'post_status'  	=> 'publish',
			    'meta_input'   => array(
			        'first_name' 	=> sanitize_text_field($_POST['first_name']),
			        'last_name' 	=> sanitize_text_field($_POST['last_name']),
			        'email' 		=> sanitize_email($_POST['email']),
			        'subject' 		=> sanitize_text_field($_POST['subject']),
			        'message' 		=> sanitize_textarea_field($_POST['message']),

			    ),
			);

			$feedback_id = wp_insert_post( $feedback_args, true );

			if(!is_wp_error($feedback_id)){
				wp_send_json_success();
			}else{
				//there was an error in the post insertion, 
				wp_send_json_error(
					array( 'message' => $feedback_id->get_error_message() )
				);
			}

		}

	}

}

new WPC_Feedback_Form_Handler;