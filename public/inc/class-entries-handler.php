<?php 
/**
 * For handling Form Entries
 */
class WPC_Feedback_Form_Listing extends WPC_Feedback_Form_Template_Loader{
	
	function __construct(){

		/* 
		 * Front end ajax hook for entries listing
		*/
		add_action(
			'wp_ajax_codeable_get_feedbacks',
			array( $this, 'codeable_get_feedbacks_cb' )
		);

		/*
		 * Front end ajax hook for fetching single feedback data
		*/
		add_action(
			'wp_ajax_codeable_get_single_feedback',
			array( $this, 'codeable_get_single_feedback_cb' )
		);

		/*
		 * Action hook for setting message for unauthorized users
		*/
		add_filter('the_content', array($this, 'codeable_feedback_content_cb') );

		/*
		 * setup the shortcode for entries list
		 */
		add_shortcode( 'feedback-list', array( $this, 'feedback_list_shortcode_cb' ) );
	}

	/*
	 * Setup message for unauthorized users
	 */
	public function get_unauthorized_message() {
		return '<div id="CodeableFeedbackForm-list" class="CodeableFeedbackForm-list"><div class="alert alert-warning" role="alert">You are not authorized to view the content of this page.</div></div>';
	}

	/*
	 * Verify user on Feedback single page
	 */
	public function codeable_feedback_content_cb($content) {
		global $post;
	    if ( $post->post_type == 'feedback' && !$this->authorize_visitors() ) {
	    	$content = $this->get_unauthorized_message();
	    }
	    return $content;
    }


    public function codeable_get_single_feedback_cb(){

    	$post_id = (int)$_POST['id'];

    	if( 
    		isset($post_id) && 
    		!empty($post_id) && 
    		is_int($post_id) && 
    		wp_verify_nonce( $_POST['feedback_nonce'], 'feedback_nonce' )
    	){
    		global $wpdb;

    		// check if feedback exists
    		if ( 
    			get_post_status( $post_id ) && 
    			get_post_type( $post_id ) == 'feedback'
    		) {
    			
    			$atts = array(
		        	// 'title' => $post_title,
		        	'first_name' => get_post_meta( $post_id, 'first_name', true ),
		        	'last_name' => get_post_meta( $post_id, 'last_name', true ),
		        	'email' => get_post_meta( $post_id, 'email', true ),
		        	'subject' => get_post_meta( $post_id, 'subject', true ),
		        	'message' => get_post_meta( $post_id, 'message', true ),
		        );

    			$this->set_template_data( $atts );
				ob_start();
			    $this->get_template_part( 'feedback', 'single' );
	    		echo ob_get_clean();
			 	die();	

    		}

		}

    }

    /*
	 * Logic to get all feedbacks
	 * @param int $pageno: page number
    */
	public function get_feedbacks( $pageno = 1 ){
		
		global $wpdb;

		$posts_per_page = 10;

		$args = array(
			'post_type' => 'feedback',
			'post_status' => 'publish',
			'posts_per_page' => $posts_per_page,
			'orderby' => 'date',
			'order' => 'DESC',
			'paged' => $pageno
		);

		// The Query
		$feedbacks = new WP_Query( $args );
		 
		// The Loop
		$return = [];
		if ( $feedbacks->have_posts() ) {
		    while ( $feedbacks->have_posts() ) {
		        $feedbacks->the_post();

		        $post_id = get_the_ID();
		        $post_title = get_the_title();

		        $return[$post_id] = array(
		        	'title' => $post_title,
		        	'first_name' => get_post_meta( $post_id, 'first_name', true ),
		        	'last_name' => get_post_meta( $post_id, 'last_name', true ),
		        	'email' => get_post_meta( $post_id, 'email', true ),
		        	'subject' => get_post_meta( $post_id, 'subject', true ),
		        	'message' => get_post_meta( $post_id, 'message', true ),
		        );
		    }
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		$return = array(
			'feedbacks' => $return,
			'page' => $pageno,
			'posts_per_page' => $posts_per_page,
			'found_posts' => $feedbacks->found_posts,
			'max_num_pages' => $feedbacks->max_num_pages,
		);

		return $return;
	}

	/* 
	 * AJAX logic for Feedback list view on pagination
	*/
	public function codeable_get_feedbacks_cb(){

		// will validate if authorized for getting feedbacks
		if( $this->authorize_visitors() && wp_verify_nonce( $_GET['feedback_nonce'], 'feedback_nonce' ) ) {

			// revieve feedbacks
			$feedbacks = $this->get_feedbacks($_GET['page']);
			$this->set_template_data( $feedbacks );
			ob_start();
		    $this->get_template_part( 'feedback', 'list' );
		    die(ob_get_clean());
		} else{
			ob_start();
			echo $content = $this->get_unauthorized_message();
			die(ob_get_clean());
		}

	} 

	/* 
	 * Shortcode logic for Feedback list view
	*/
	public function feedback_list_shortcode_cb(){
		
		// will validate if authorized for getting feedbacks
		if( $this->authorize_visitors() ) {

			// revieve feedbacks
			$feedbacks = $this->get_feedbacks();
			$this->set_template_data( $feedbacks );
		    ob_start();
		    echo '<div id="CodeableFeedbackForm-list-wrapper" class="alignwide">';
		 	$this->get_template_part( 'feedback', 'list' );
		 	echo '</div>';
		 	return ob_get_clean();
		} else{
			ob_start();
			echo $content = $this->get_unauthorized_message();
			return ob_get_clean();
		}

	}

	/* Authorize the user for feedbacks recieve request
     *
     * @return boolean 0,1
     */
	public function authorize_visitors(){
		// check if user is admin user or not
		return current_user_can( 'manage_options' ) ? true : false;
	}
}

new WPC_Feedback_Form_Listing;