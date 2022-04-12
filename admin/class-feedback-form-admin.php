<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Feedback_Form
 * @subpackage Feedback_Form/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Feedback_Form
 * @subpackage Feedback_Form/admin
 * @author     Prakash Rao <prakash@wordpresscapital.com>
 */
class WPC_Feedback_Form_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feedback_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feedback_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/feedback-form-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feedback_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feedback_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/feedback-form-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * @since    1.0.0
	 */
	public function register_custom_post_type(){
            

        /**
         * Post Type: Feedbacks.
         */

        $labels = [
            "name" => __( "Feedbacks", "feedback-form" ),
            "singular_name" => __( "Feedback", "feedback-form" ),
            "menu_name" => __( "Feedbacks", "feedback-form" ),
            "all_items" => __( "All Feedbacks", "feedback-form" ),
            "add_new" => __( "Add new", "feedback-form" ),
            "add_new_item" => __( "Add new Feedback", "feedback-form" ),
            "edit_item" => __( "Edit Feedback", "feedback-form" ),
            "new_item" => __( "New Feedback", "feedback-form" ),
            "view_item" => __( "View Feedback", "feedback-form" ),
            "view_items" => __( "View Feedbacks", "feedback-form" ),
            "search_items" => __( "Search Feedbacks", "feedback-form" ),
            "not_found" => __( "No Feedbacks found", "feedback-form" ),
            "not_found_in_trash" => __( "No Feedbacks found in trash", "feedback-form" ),
            "parent" => __( "Parent Feedback:", "feedback-form" ),
            "featured_image" => __( "Featured image for this Feedback", "feedback-form" ),
            "set_featured_image" => __( "Set featured image for this Feedback", "feedback-form" ),
            "remove_featured_image" => __( "Remove featured image for this Feedback", "feedback-form" ),
            "use_featured_image" => __( "Use as featured image for this Feedback", "feedback-form" ),
            "archives" => __( "Feedback archives", "feedback-form" ),
            "insert_into_item" => __( "Insert into Feedback", "feedback-form" ),
            "uploaded_to_this_item" => __( "Upload to this Feedback", "feedback-form" ),
            "filter_items_list" => __( "Filter Feedbacks list", "feedback-form" ),
            "items_list_navigation" => __( "Feedbacks list navigation", "feedback-form" ),
            "items_list" => __( "Feedbacks list", "feedback-form" ),
            "attributes" => __( "Feedbacks attributes", "feedback-form" ),
            "name_admin_bar" => __( "Feedback", "feedback-form" ),
            "item_published" => __( "Feedback published", "feedback-form" ),
            "item_published_privately" => __( "Feedback published privately.", "feedback-form" ),
            "item_reverted_to_draft" => __( "Feedback reverted to draft.", "feedback-form" ),
            "item_scheduled" => __( "Feedback scheduled", "feedback-form" ),
            "item_updated" => __( "Feedback updated.", "feedback-form" ),
            "parent_item_colon" => __( "Parent Feedback:", "feedback-form" ),
        ];

        $args = [
            "label" => __( "Feedbacks", "feedback-form" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => true,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "feedback", "with_front" => true ],
            "query_var" => true,
            "menu_icon" => "dashicons-format-quote",
            "supports" => [ "title", "custom-fields" ],
            "show_in_graphql" => false,
        ];

        register_post_type( "feedback", $args );

    }

	/**
	 * Set up and add the meta box.
	 */
    public function add_meta_boxes_cb(){
    	$post_types = [ 'feedback' ];
        foreach ( $post_types as $post_type ) {
            add_meta_box(
                'first_name',
                'First Name',
                [ $this, 'first_name_render' ],
                $post_type
            );

            add_meta_box(
                'last_name',
                'Last Name',
                [ $this, 'last_name_render' ],
                $post_type
            );

            add_meta_box(
                'email',
                'First Name',
                [ $this, 'email_render' ],
                $post_type
            );

            add_meta_box(
                'subject',
                'Subject',
                [ $this, 'subject_render' ],
                $post_type
            );

            add_meta_box(
                'message',
                'Message',
                [ $this, 'message_render' ],
                $post_type
            );
        }
    }

    /**
     * Save the meta box selections.
     *
     * @param int $post_id  The post ID.
     */
    public function save_meta_boxes_cb( $post_id ) {

    	if ( array_key_exists( 'first_name', $_POST ) ) {
            update_post_meta(
                $post_id,
                'first_name',
                $_POST['first_name']
            );
        }

        if ( array_key_exists( 'last_name', $_POST ) ) {
            update_post_meta(
                $post_id,
                'last_name',
                $_POST['last_name']
            );
        }

        if ( array_key_exists( 'email', $_POST ) ) {
            update_post_meta(
                $post_id,
                'email',
                $_POST['email']
            );
        }

        if ( array_key_exists( 'subject', $_POST ) ) {
            update_post_meta(
                $post_id,
                'subject',
                $_POST['subject']
            );
        }

        if ( array_key_exists( 'message', $_POST ) ) {
            update_post_meta(
                $post_id,
                'message',
                $_POST['message']
            );
        }
    }
 
 
    /**
     * Display First Name meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function first_name_render( $post ) {
        $first_name = get_post_meta( $post->ID, 'first_name', true );
        ?>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" class="postbox" value="<?php echo $first_name; ?>" />
        <?php
    }

    /**
     * Display Last Name meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function last_name_render( $post ) {
        $last_name = get_post_meta( $post->ID, 'last_name', true );
        ?>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="postbox" value="<?php echo $last_name; ?>" />
        <?php
    }

    /**
     * Display Email meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function email_render( $post ) {
        $email = get_post_meta( $post->ID, 'email', true );
        ?>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="postbox" value="<?php echo $email; ?>" />
        <?php
    }

    /**
     * Display First Name meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function subject_render( $post ) {
        $subject = get_post_meta( $post->ID, 'subject', true );
        ?>
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" class="postbox" value="<?php echo $subject; ?>" />
        <?php
    }

    /**
     * Display Message meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function message_render( $post ) {
        $message = get_post_meta( $post->ID, 'message', true );
        ?>
        <label for="message">Message</label>
        <input type="text" name="message" id="message" class="postbox" value="<?php echo $message; ?>" />
        <?php
    }

}
