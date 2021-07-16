<?php

class Shortcodes {

		/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	
	}


	/**
	 * Processes shortcode get_a_quote with react frontend
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 * @return	mixed	$output		Output of the buffer
	 */
	public function fb_process_order_shortcode($atts) {

		// Test if the query exists at the URL
		$parameters = $_GET;
		$end = 20;

		if ((array_key_exists("action",$parameters) ) ) { 
			return true;
		} 

		if (!(array_key_exists("thank_you_page",$parameters)) || ( ! is_user_logged_in() )) { 
			$url = home_url();
			return wp_redirect( $url );
		}

		$id_user = get_current_user_id();

		// Now we create the order
		$order = wc_create_order(array('customer_id' => $id_user));

		for ($i=1; $i < $end; $i++) { 
			$name =  'Item'.$i.'_name';
			if (!empty($parameters[$name])) {

				$link = 'Item'.$i.'_link';
				$price = 'Item'.$i.'_Price';
				$price = 1;
				$quantity = 'Item'.$i.'_quantity';
				$options = 'Item'.$i.'_option';
				//$shipping = 'Item'.$i.'_FR_delivery';
				$product_id = wp_insert_post(array(
					'post_title' => sanitize_text_field(remove_accents($parameters[$name])),
					'post_type' => 'product',
					'post_status' => 'publish',
					'post_content' => $parameters[$link],
					'post_excerpt' => (empty($parameters[$options])) ? '' : sanitize_text_field(remove_accents($parameters[$options]))
				));
					
				update_post_meta($product_id, '_regular_price', 0);
				update_post_meta($product_id, '_price', 0);

				$order->add_product( get_product( $product_id ), $parameters[$quantity] );				
				
				
			} else {
				break;
			}
		}

		$address = array(
			'first_name' => get_user_meta( $id_user, 'first_name', true ),
			'last_name'	=> get_user_meta(  $id_user, 'last_name', true ),
			'phone'      => get_user_meta( $id_user, 'billing_phone', true ),
			'address_1'  => get_user_meta( $id_user, 'billing_address_1', true ),
			'city'       => get_user_meta( $id_user, 'billing_city', true ),
			'postcode'   => get_user_meta( $id_user, 'billing_postcode', true ),
			'country'    => get_user_meta( $id_user, 'billing_country', true )
		);

		$order->set_address( $address, 'billing' );

		if (!(in_array("same_address", $parameters))) {
			$address = array(
				'first_name' => $parameters['Customer_Contact'],
				'phone'      => $parameters['Customer_phone'],
				'address_1'  => $parameters['Customer_Adresse'],
				'address_2'  => $parameters['Customer_info'],
				'city'       => $parameters['Customer_City'],
				'postcode'   => $parameters['Customer_NPA'],
				'country'    => $parameters['Customer_Country']
			);

			$order->set_address( $address, 'shipping' );

		}

		//Set status of order
		$order->update_status("quote-pendding");

		$url = site_url() . $parameters['thank_you_page'];
		return wp_redirect( $url );
		
	}
	
	public function fb_process_subcription_shortcode ($atts) {

		$parameters = $_GET;
		
		if (empty($parameters)) { 
			return false;
		}

		$email = trim($parameters['Email']);

		if ( empty( $email ) || ! is_email( $email ) ) {
			return false;
		}
	  
	  
		$password = $parameters['Registration_Password'];

		sleep(2);

		$user = get_user_by( 'email', $email ); 

		if( ($user)  && (!is_user_logged_in())) {

			$user_id = $user->ID;
			wp_set_current_user( $user_id, $user_login );
			wp_set_auth_cookie( $user_id );
			do_action( 'wp_login', $user_login );

		}  

		return wp_redirect( wc_get_page_permalink('myaccount') );
	

	}

		/**
	 * Render React Form to create user + order product + subscription
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 * @return	mixed	$output		Output of the buffer
	 */

	public function fb_subscription_form_shortcode( $atts ) {

		wp_enqueue_style( $this->plugin_name . '-subscription-form' );

		// Get the SKU by queryparams
		$plan = $_GET['plan'];
		$sku = trim($plan);

		if ( is_user_logged_in() ) {

			ob_start();
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/frouzebox-plugin-logged-message.php';
			$output = ob_get_contents();
			ob_end_clean();
			
	 } elseif (!empty($sku) && ($_product_id = wc_get_product_id_by_sku($sku))) {
			
			$_plan = wc_get_product( $_product_id );

			$object_name = 'fb_object_' . uniqid();

			$object = array(
				'api_nonce'   => wp_create_nonce( 'wp_rest' ),
				'api_url'	  => rest_url( $this->plugin_name . '/' ),
				'locale'	=> ICL_LANGUAGE_CODE,
				'plan' => array(
					'sku' => $sku,
					'price_html' => $_plan->get_price_html(),
					'price' => $_plan->get_price(),
					'regular_price' => $_plan->get_regular_price(),
					'period' => WC_Subscriptions_Product::get_period( $_product_id )
				)
			);
			
			// Include strings file
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/strings/form.php';

			// Localize vars
			
			wp_localize_script( $this->plugin_name . '-subscription-form', 'strings', $strings );
			wp_localize_script( $this->plugin_name . '-subscription-form', $object_name, $object );

			// Enqueue script js
			wp_enqueue_script(  $this->plugin_name . '-subscription-form' );
			
			$output = '<div id="fb-subscription-form" class="subscription-form" data-object-id="' . $object_name . '"></div>';

	 } else {

		ob_start();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/frouzebox-plugin-error-message.php';
		$output = ob_get_contents();
		ob_end_clean();

	 }
		

		return $output;
	}

	
	
	
	
	
	
}


	

