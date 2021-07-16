<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://maturocha.com.ar
 * @since      1.0.0
 *
 * @package    Frouzebox_Plugin
 * @subpackage Frouzebox_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Frouzebox_Plugin
 * @subpackage Frouzebox_Plugin/admin
 * @author     Matur <matu.rocha@gmail.com>
 */
class Frouzebox_Plugin_Admin {

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
		 * defined in Frouzebox_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frouzebox_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/frouzebox-plugin-admin.css', array(), $this->version, 'all' );

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
		 * defined in Frouzebox_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frouzebox_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/frouzebox-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_menu() {

		/*MENU NUEVO */

		$page_title = __( 'Frouze Box', 'frouzebox-plugin' );
		$menu_title = __( 'Frouze Box', 'frouzebox-plugin' );
		$capability = 'manage_options';
		$menu_slug = 'frouzebox-panel';
		$icon_menu = 'dashicons-hammer';
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, '', $icon_menu, 81 );

		$sub_page_title = __( 'Options', 'frouzebox-plugin' );
		$sub_menu_title = __( 'Options', 'frouzebox-plugin' );
		$sub_menu_slug = 'fb-general-options';
		$sub_menu_function =  array( $this, 'display_general_page' );
		add_submenu_page( $menu_slug, $sub_page_title, $sub_menu_title, $capability, $sub_menu_slug, $sub_menu_function );

		$sub_page_title = __( 'WC Settings', 'frouzebox-plugin' );
		$sub_menu_title = __( 'WC Settings', 'frouzebox-plugin' );
		$sub_menu_slug = 'fb-wc-settings';
		$sub_menu_function =  array( $this, 'display_wc_settings_page' );
		add_submenu_page( $menu_slug, $sub_page_title, $sub_menu_title, $capability, $sub_menu_slug, $sub_menu_function );

		remove_submenu_page( $menu_slug, $menu_slug );

	} // add_menu()

	public function display_general_page() {

		include( 'partials/frouzebox-plugin-admin-general-panel.php' );

	}

	public function display_wc_settings_page() {

		include( 'partials/frouzebox-plugin-admin-my-account-setting.php' );

	}

		/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_general_settings() {

		//General Settings Field

		register_setting(
			'fb_snippets_plugin_options_group', // Option group
			'fb_snippets_plugin_options' // Option name
		);

		add_settings_section(
			'fb_snippets_plugin_section', // ID
			'Snippets', // Title
			null, // Callback
			'fb_snippets_plugin_options' // Page
		); 
		
		add_settings_field(
			"fb_snippets_before_head",	// ID
			"Snippets before < head >",
			array( $this, 'display_textarea_field' ), 		// // The name of the function responsible for rendering the option interface 
			"fb_snippets_plugin_options",		// The page on which this option will be displayed 
			"fb_snippets_plugin_section",		// The name of the section to which this field belongs
			array(  
				'fb_snippets_plugin_options',  					// The array of arguments to pass to the callback.   
				'fb_snippets_before_head',
				'Code snippet above the closing < head > tag'
			)
		); 

		add_settings_field(
			"fb_snippets_after_body",	// ID
			"Snippets after < body >",
			array( $this, 'display_textarea_field' ), 		// // The name of the function responsible for rendering the option interface 
			"fb_snippets_plugin_options",		// The page on which this option will be displayed 
			"fb_snippets_plugin_section",		// The name of the section to which this field belongs
			array(  
				'fb_snippets_plugin_options',  					// The array of arguments to pass to the callback.   
				'fb_snippets_after_body',
				'Code snippet above the closing < body > tag'
			)
		); 


	} // add_new_settings()

	public function add_myaccount_settings() {

		//General Settings Field

		//General Settings Field
		register_setting(
			'fb_myaccount_options_group', // Option group
			'fb_myaccount_options' // Option name
		);

		add_settings_section(
			'fb_wc_options_section', // ID
			'WC My Account Settings', // Title
			null, // Callback
			'fb_myaccount_options' // Page
		);  

		add_settings_field(
			"fb_shortcode_order",	// ID
			"Shortcode Order",
			array( $this, 'display_select_pages' ), 		// // The name of the function responsible for rendering the option interface 
			"fb_myaccount_options",		// The page on which this option will be displayed 
			"fb_wc_options_section",		// The name of the section to which this field belongs
			array(    					// The array of arguments to pass to the callback.  
				'fb_myaccount_options',  
				'fb_shortcode_order',
				'The page of order form'
			)
		);

		add_settings_field(
			"fb_faq_page",	// ID
			"FAQ Page",
			array( $this, 'display_select_pages' ), 		// // The name of the function responsible for rendering the option interface 
			"fb_myaccount_options",		// The page on which this option will be displayed 
			"fb_wc_options_section",		// The name of the section to which this field belongs
			array(    					// The array of arguments to pass to the callback.  
				'fb_myaccount_options',  
				'fb_faq_page',
				'The page of FAQ Page'
			)
		);

		add_settings_field(
			"fb_typ_subscription_paid",	// ID
			"TYP Subscription",
			array( $this, 'display_select_pages' ), 		// // The name of the function responsible for rendering the option interface 
			"fb_myaccount_options",		// The page on which this option will be displayed 
			"fb_wc_options_section",		// The name of the section to which this field belongs
			array(    					// The array of arguments to pass to the callback.  
				'fb_myaccount_options',  
				'fb_typ_subscription_paid',
				'The TYP after paid a subscription'
			)
		);
	


	} // add_new_settings()

	

	public function display_textarea_field($args)
	{

	$option = $args[0];
	$key = $args[1];
	$options_list = get_option($option);
	$value = (isset($options_list[$key])) ? esc_attr($options_list[$key]) : '';
	$nameField = $option . "[" . $key . "]";

	?>

	<textarea id="<?php echo $key ?>" name="<?php echo $nameField ?>" cols="40" rows="3" class="" aria-required="true" aria-invalid="false" placeholder="Text..."><?php echo $value ?></textarea>


	<?php

	if (!(empty($args[2]))) { ?>

		<p class="description" id="tagline-description"><?php echo $args[2]; ?></p>
		<?php
	}


}

	public function display_text_field($args)
	{

	$option = $args[0];
	$key = $args[1];
	$options_list = get_option($option);
	$value = (isset($options_list[$key])) ? esc_attr($options_list[$key]) : '';
	$nameField = $option . "[" . $key . "]";

	?>

	<input type='text' id='<?php echo $key ?>' name='<?php echo $nameField ?>' value='<?php echo $value ?>' />

	<?php

	if (!(empty($args[2]))) { ?>

		<p class="description" id="tagline-description"><?php echo $args[2]; ?></p>
		<?php
	}


	}

	public function display_select_pages($args) {
		$option = $args[0];
		$key = $args[1];
		$options_list = get_option($option);
		$value = (isset($options_list[$key])) ? $options_list[$key] : false;
		$options = $args[2];
		$nameField = $option . "[" . $key . "]";
		// Get all pages
		$pages = get_pages();
		?>
		<?php if ( $pages ) { ?>
			<select id="<?php echo $key ?>" name="<?php echo $nameField ?>">
				<option></option>
				<?php foreach ( $pages as $page ) { ?>
					<option value='<?php echo esc_attr( $page->ID ); ?>' <?php selected( $value, $page->ID ); ?>><?php echo esc_html( $page->post_title ); ?></option>
				<?php } ?>
			</select>
					
		<?php
		
		}
	
		if (!(empty($args[2]))) { ?>
			<p class="description" id="tagline-description"><?php echo $args[2]; ?></p>
			<?php
		}
	
	}

}


