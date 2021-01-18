<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Cpt
 * @subpackage Cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cpt
 * @subpackage Cpt/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Cpt_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function c_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-c-select2-css', CPT_DIR_URL . 'admin/css/cpt-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, CPT_DIR_URL . 'admin/css/cpt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function c_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-c-select2', CPT_DIR_URL . 'admin/js/cpt-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', CPT_DIR_URL . 'admin/js/cpt-admin.js', array( 'jquery', 'mwb-c-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'c_admin_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=cpt_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for CPT.
	 *
	 * @since    1.0.0
	 */
	public function c_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'cpt' ), __( 'MakeWebBetter', 'cpt' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), CPT_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$c_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $c_menus ) && ! empty( $c_menus ) ) {
				foreach ( $c_menus as $c_key => $c_value ) {
					add_submenu_page( 'mwb-plugins', $c_value['name'], $c_value['name'], 'manage_options', $c_value['menu_link'], array( $c_value['instance'], $c_value['function'] ) );
				}
			}
		}
	}


	/**
	 * CPT c_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function c_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'CPT', 'cpt' ),
			'slug'            => 'cpt_menu',
			'menu_link'       => 'cpt_menu',
			'instance'        => $this,
			'function'        => 'c_options_menu_html',
		);
		return $menus;
	}


	/**
	 * CPT mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require CPT_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * CPT admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function c_options_menu_html() {

		include_once CPT_DIR_PATH . 'admin/partials/cpt-admin-display.php';
	}

	/**
	 * CPT admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $c_settings_general Settings fields.
	 */
	public function c_admin_general_settings_page( $c_settings_general ) {
		$c_settings_general = array(
			array(
				'title' => __( 'Text Field Demo', 'cpt' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_text_demo',
				'value' => '',
				'class' => 'c-text-class',
				'placeholder' => __( 'Text Demo', 'cpt' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'cpt' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_number_demo',
				'value' => '',
				'class' => 'c-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'cpt' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_password_demo',
				'value' => '',
				'class' => 'c-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'cpt' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_textarea_demo',
				'value' => '',
				'class' => 'c-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'cpt' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'cpt' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_select_demo',
				'value' => '',
				'class' => 'c-select-class',
				'placeholder' => __( 'Select Demo', 'cpt' ),
				'options' => array(
					'INR' => __( 'Rs.', 'cpt' ),
					'USD' => __( '$', 'cpt' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'cpt' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_multiselect_demo',
				'value' => '',
				'class' => 'c-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'cpt' ),
				'options' => array(
					'INR' => __( 'Rs.', 'cpt' ),
					'USD' => __( '$', 'cpt' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'cpt' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_checkbox_demo',
				'value' => '',
				'class' => 'c-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'cpt' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'cpt' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'cpt' ),
				'id'    => 'c_radio_demo',
				'value' => '',
				'class' => 'c-radio-class',
				'placeholder' => __( 'Radio Demo', 'cpt' ),
				'options' => array(
					'yes' => __( 'YES', 'cpt' ),
					'no' => __( 'NO', 'cpt' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'c_button_demo',
				'button_text' => __( 'Button Demo', 'cpt' ),
				'class' => 'c-button-class',
			),
		);
		return $c_settings_general;
	}
	// Custom Code.

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function wporg_settings_init() {
		// Register a new setting for "wporg" page.
		register_setting( 'wporg', 'wporg_options' );

		// Register a new section in the "wporg" page.
		add_settings_section(
			'wporg_section_developers',
			__( 'The Mandatory Field.', 'wporg' ), array( $this, 'wporg_section_developers_callback' ),
			'wporg'
		);

		// Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
		add_settings_field(
			'wporg_field_pill_review', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
				__( 'Review', 'wporg' ),
			array( $this, 'wporg_field_pill_review' ),
			'wporg',
			'wporg_section_developers',
			array(
				'label_for'         => 'wporg_field_pill_review',
				'class'             => 'wporg_row',
				'wporg_custom_data' => 'custom',
			)
		);

		add_settings_field(
			'wporg_field_pill_rating', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
				__( 'Rating', 'wporg' ),
			array( $this, 'wporg_field_pill_rating' ),
			'wporg',
			'wporg_section_developers',
			array(
				'label_for'         => 'wporg_field_pill_rating',
				'class'             => 'wporg_row',
				'wporg_custom_data' => 'custom',
			)
		);
	}

	/**
	 * Register our wporg_settings_init to the admin_init action hook.
	 */
	// add_action( 'admin_init', 'wporg_settings_init' );.


	/**
	 * Custom option and settings:
	 *  - callback functions
	 */


	/**
	 * Developers section callback function.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	public function wporg_section_developers_callback( $args ) {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Select Your Mandatory Field Here.', 'wporg' ); ?></p>
		<?php
	}

	/**
	 * Pill field callbakc function.
	 *
	 * WordPress has magic interaction with the following keys: label_for, class.
	 * - the "label_for" key value is used for the "for" attribute of the <label>.
	 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
	 * Note: you can add custom key value pairs to be used inside your callbacks.
	 *
	 * @param array $args
	 */
	public function wporg_field_pill_review( $args ) {
		// Get the value of the setting we've registered with register_setting().
		$options = get_option( 'wporg_options' );
		?>
		<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]"  <?php if ( isset( $options['wporg_field_pill_review'] ) ) { echo 'checked'; } ?> > <?php esc_html_e('Review'); ?> <br><br>

		<?php
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $args
	 * @return void
	 */
	public function wporg_field_pill_rating( $args ) {
		// Get the value of the setting we've registered with register_setting().
		$options = get_option( 'wporg_options' );
		?>
		<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]" <?php if( isset( $options['wporg_field_pill_rating'] ) ) { echo 'checked';}?> > <?php esc_html_e( 'Rating' ); ?> <br><br>

		<?php
	}

	/**
	 * Add the top level menu page.
	 */
	public function wporg_options_page() {
		add_menu_page(
			'MWB',
			'Mandatory Fields',
			'manage_options',
			'wporg',
			array( $this, 'wporg_options_page_html' )
		);
	}


	/**
	 * Register our wporg_options_page to the admin_menu action hook.
	 */
	// add_action( 'admin_menu', 'wporg_options_page' );.


	/**
	 * Top level menu callback function
	 */
	public function wporg_options_page_html() {
		// check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// add error/update messages.

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url.
		if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated".
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
		}

		// show error/update messages.
		settings_errors( 'wporg_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				// output security fields for the registered setting "wporg".
				settings_fields( 'wporg' );
				// output setting sections and their fields
				// (sections are registered for "wporg", each field is registered to a specific section).
				do_settings_sections( 'wporg' );
				// output save settings button.
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function create_posttype() {

		register_post_type(
			'people',
			// CPT Options.
			array(
				'labels'        => array(
					'name'          => __( 'Peoples' ),
					'singular_name' => __( 'People' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'people' ),
				'show_in_rest' => false,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'headway-seo' ),

			)
		);
	}
	// Hooking up our function to theme setup.
	// add_action( 'init', 'create_posttype' ); .

	/**
	 * Undocumented function
	 *
	 * @param [type] $query contains string.
	 * @return string
	 */
	public function add_my_post_types_to_query( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post', 'people' ) );
			return $query;
		}
	}
	// add_action( 'pre_get_posts', 'add_my_post_types_to_query' ); .

	/**
	 * Set up and add the meta box.
	 */
	public function add() {
		$screens = array( 'people' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'wporg_box_id',          // Unique ID.
				'Feedback', // Box title.
				array( $this, 'html' ),   // Content callback, must be of type callable.
				$screen             // Post type.
			);
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public function save( int $post_id ) {
		// if ( wp_verify_nonce( isset( $_POST['nonce'] ) ) ) {
		// die( 'in' );
		// } else {
		// die( 'out' );
		// }.
		if ( isset( $_POST['contactno'] ) ) {
			update_post_meta(
				$post_id,
				'contactno',
				$_POST['contactno']// phpcs:ignore.
			);
		}

		if ( isset( $_POST['address'] ) ) {// phpcs:ignore.
			update_post_meta(
				$post_id,
				'address',
				$_POST['address']// phpcs:ignore.
			);
		}

		if ( isset( $_POST['review'] ) ) {// phpcs:ignore.
			update_post_meta(
				$post_id,
				'review',
				$_POST['review']// phpcs:ignore.
			);
		}

		if ( isset( $_POST['rating'] ) ) {// phpcs:ignore.
			update_post_meta(
				$post_id,
				'rating',
				$_POST['rating']// phpcs:ignore.
			);
		}
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public function html( $post ) {
		$value = get_post_meta( $post->ID, '_wporg_meta_key', true );

		?>

		<input type="hidden" name="nonce" value="<?php echo esc_html( wp_create_nonce() ); ?>">

		<label for="contactno">Contact No: </label>
		<input type="text" name="contactno" id="contactno"  class="postbox" value=" <?php echo esc_html( get_post_meta( get_the_ID(), 'contactno', true ) ); ?>"><br><br>

		<label for="address">Address: </label>
		<input type="text" name="address" id="address"  class="postbox" value=" <?php echo esc_html( get_post_meta( get_the_ID(), 'address', true ) ); ?>"><br><br>

		<?php
		$options = get_option( 'wporg_options' );
		// print_r($options);.
		// die();.
		if ( 'on' === $options['wporg_field_pill_review'] ) {

			?>
			<label for="review">Review: </label>
			<input type="text" name="review" id="review"  class="postbox" 	value=" <?php echo esc_html( get_post_meta( get_the_ID(), 'review', true ) ); ?>"><br><br>

			<?php
		}
		if ( 'on' === $options['wporg_field_pill_rating'] ) {
			?>
			<label for="rating">Rating: </label>
			<input type="text" name="rating" id="rating"  class="postbox" 	value=" <?php echo esc_html( get_post_meta( get_the_ID(), 'rating', true ) ); ?>"><br><br>
			<?php

		}
	}
	// add_action( 'add_meta_boxes', array( 'WPOrg_Meta_Box', 'add' ) );
	// add_action( 'save_post', array( 'WPOrg_Meta_Box', 'save' ) );.


}
