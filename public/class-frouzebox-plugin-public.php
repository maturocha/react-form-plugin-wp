<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://maturocha.com.ar
 * @since      1.0.0
 *
 * @package    Frouzebox_Plugin
 * @subpackage Frouzebox_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Frouzebox_Plugin
 * @subpackage Frouzebox_Plugin/public
 * @author     Matur <matu.rocha@gmail.com>
 */
class Frouzebox_Plugin_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/frouzebox-plugin-public.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . '-subscription-form', plugin_dir_url( __FILE__ ) . 'css/frouzebox-plugin-subscription-form.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/frouzebox-plugin-public.js', array( 'jquery' ), $this->version, false );
		wp_register_script( $this->plugin_name . '-subscription-form', plugin_dir_url( __FILE__ ) . 'js/frouzebox-plugin-subscription-form.js', array( ), $this->version, false );

	}


	function add_rest_endpoints(){

		// include shortcodes definitions file
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-endpoints.php';

		$endpoints = new Endpoints($this->plugin_name, $this->version);

		register_rest_route( 'frouzehooks', 'process-order', array(
	    'methods' => WP_REST_Server::ALLMETHODS,
			'callback' =>  array( $endpoints, 'fb_process_order'),

		));

		register_rest_route( $this->plugin_name, 'create-subscription', array(
			array(
					'methods'               => \WP_REST_Server::CREATABLE,
					'callback'              => array( $endpoints, 'fb_create_suscription_process_2'),
					'args'                  => array(),
				),
			) );

		register_rest_route( $this->plugin_name, 'email-exists', array(
			array(
					'methods'               => \WP_REST_Server::READABLE,
					'callback'              => array( $endpoints, 'fb_email_exists'),
					'args'                  => array(),
				),
			) );

	} // add_rest_endpoints

	public function register_shortcodes() {

		// include shortcodes definitions file
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-shortcodes.php';

		$shortcodes = new Shortcodes($this->plugin_name, $this->version);

		//Shortcode to procces de form order
		add_shortcode( 'fb-process-order', array( $shortcodes, 'fb_process_order_shortcode' ));
		add_shortcode( 'fb-process-subscription', array( $shortcodes, 'fb_process_subcription_shortcode' ));
		add_shortcode( 'fb-subscription-form', array( $shortcodes, 'fb_subscription_form_shortcode' ));

	}


		/**
		 * This function add scripts in head tag.
		 *
		 */

	public function before_head_snippets() {

		//Snippets options
		$options_list = get_option('fb_snippets_plugin_options');

		//Get after body setting
		if ($value = $options_list['fb_snippets_before_head']) {

			echo $value;

		}


	}

	public function after_body_snippets() {

		//Snippets options
		$options_list = get_option('fb_snippets_plugin_options');

		//Get after body setting
		if ($value = $options_list['fb_snippets_after_body']) {

			echo $value;

		}


	}


}
