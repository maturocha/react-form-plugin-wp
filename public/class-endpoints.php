<?php

class Endpoints {

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
	 * Endpoint proccess WC Order by GET params
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 * @return	mixed	$output		Output of the buffer
	 */
	public function fb_process_order() {

			// Test if the query exists at the URL
			$parameters = $_GET;
			$end = 20;
	
			if (empty($parameters)) { 
				return false;
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
						'post_title' => $parameters[$name],
						'post_type' => 'product',
						'post_status' => 'publish',
						'post_content' => $parameters[$link],
						'post_excerpt' => (empty($parameters[$options])) ? '' : $parameters[$options]
					));
						
					update_post_meta($product_id, '_regular_price', 0);
					update_post_meta($product_id, '_price', 0);
	
					$order->add_product( get_product( $product_id ), $parameters[$quantity] );				
					
					
				} else {
					break;
				}
			}
	
			if (!(in_array("same_address", $parameters))) {
				$address = array(
					'first_name' => $parameters['Customer_Contact'],
					'phone'      => $parameters['Customer_phone'],
					'address_1'  => $parameters['Customer_Adresse'],
					'city'       => $parameters['Customer_City'],
					'postcode'   => $parameters['Customer_NPA'],
					'country'    => $parameters['Customer_Country']
				);
	
				$order->set_address( $address, 'shipping' );
	
			}
	
			//Set status of order
			$order->update_status("quote-pendding");
	
			$url = get_permalink( wc_get_page_id( 'myaccount' ) );
			return wp_redirect( $url );
	
		
	}

		/**
	 * Endpoint create user + WC Order + WC Subscription
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 * @return	mixed	$output		Output of the buffer
	 */

	public function fb_create_suscription_process( $request ) {

		$parameters = $request->get_param( 'params' );

		if (empty($parameters)) { 
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Empty data'
			), 403 );
		}

		$personal = $parameters['personal'];
		$addresInformation = $parameters['address'];
		$info = $parameters['final'];
		$username = $email = $personal['email'];

		if ( empty( $username ) || ! validate_username( $username ) ) {
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error email'
			), 403 );
		}
	  
		if ( username_exists( $username ) ) {
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Username exists.'
			), 403 );
		}

		$password = $personal['password'];
	
		$new_customer_data = apply_filters(
		'woocommerce_new_customer_data',
			array(
			'user_login' => $username,
			'user_pass'  => $password,
			'user_email' => $email,
			'role'       => 'customer',
			)
		);
	  
		$customer_id = wp_insert_user( $new_customer_data );


		//Names
		$firstname = sanitize_text_field($personal['firstname']);
		$lastname = sanitize_text_field($personal['lastname']);


		update_user_meta( $customer_id, "first_name",  $firstname ) ;
		update_user_meta( $customer_id, "last_name",  $lastname ) ;
		//update_user_meta( $customer_id, 'description', $parameters['ref'] );
		update_user_meta( $customer_id, 'locale', $info['locale'] );

		//user's billing data
		$address = sanitize_text_field( $addresInformation['address']);
		$city = sanitize_text_field($addresInformation['city']);
		$company = sanitize_text_field($addresInformation['company']);
		$phone = $personal['phone'];
		$postcode = $addresInformation['postalCode'] ;
		update_user_meta( $customer_id, 'billing_address_1', $address  );
		update_user_meta( $customer_id, 'billing_address_2', '' );
		update_user_meta( $customer_id, 'billing_city', $city );
		update_user_meta( $customer_id, 'billing_company', $company );
		update_user_meta( $customer_id, 'billing_country', 'CH' );
		update_user_meta( $customer_id, 'billing_email', $email );
		update_user_meta( $customer_id, 'billing_first_name', $firstname );
		update_user_meta( $customer_id, 'billing_last_name', $lastname );
		update_user_meta( $customer_id, 'billing_phone', $phone );
		update_user_meta( $customer_id, 'billing_postcode', $postcode );
		//update_user_meta( $customer_id, 'billing_state', $parameters['Email'] );


		// First make sure all required functions and classes exist
		if( ! function_exists( 'wc_create_order' ) || ! function_exists( 'wcs_create_subscription' ) || ! class_exists( 'WC_Subscriptions_Product' ) ){
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error existing functions.'
			), 403 );
		}
	
		$order = wc_create_order( array( 'customer_id' => $customer_id ) );
		if( is_wp_error( $order ) ){
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error creating order.'
			), 403 );
		}
	
		$address         = array(
			'first_name' => $firstname,
			'last_name'  => $lastname,
			'email'      => $email,
			'address_1'  => $address,
			//'address_2'  => $address_2,
			'city'       => $city,
			//'state'      => $state,
			'postcode'   => $postcode,
			'country'    => $country,
		);

		$product_id = wc_get_product_id_by_sku($info['sku']);
		$product = get_product( $product_id );

	
		$order->set_address( $address, 'billing' );
		$order->set_address( $address, 'shipping' );
		// $order->set_payment_method( 'stripe' );
		// $order->set_payment_method_title( 'Credit Card' );
		$order->add_product( $product, 1 );
	
		$sub = wcs_create_subscription(array(
			'order_id' => $order->get_id(),
			'customer_id'      => $customer_id,
			'status' => 'pending', // Status should be initially set to pending to match how normal checkout process goes
			'billing_period' => WC_Subscriptions_Product::get_period( $product ),
			'billing_interval' => WC_Subscriptions_Product::get_interval( $product ),
			'requires_manual_renewal' => false,
			'cancelled_email_sent'    => false
		));
	
		if( is_wp_error( $sub ) ){
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error.'
			), 403 );
		}
	
		// Modeled after WC_Subscriptions_Cart::calculate_subscription_totals()
		$start_date = gmdate( 'Y-m-d H:i:s' );
		$sub->add_product($product, 1 );

		// $sub->set_payment_method( 'stripe' );
		// $sub->set_payment_method_title( 'Credit Card' );
		$sub->set_address( $address, 'billing' );
	
		$dates = array(
			'trial_end'    => WC_Subscriptions_Product::get_trial_expiration_date( $product, $start_date ),
			'next_payment' => WC_Subscriptions_Product::get_first_renewal_payment_date( $product, $start_date ),
			'end'          => WC_Subscriptions_Product::get_expiration_date( $product, $start_date ),
		);
	
		$sub->update_dates( $dates );
		$sub->calculate_totals();
		$order->calculate_totals();
	
		// Update order status with custom note
		$note = ! empty( $note ) ? $note : __( 'Programmatically added by Frouzebox Plugin.' );
		$order->update_status( 'pending', $note, true );


		//Log in
		$user = get_user_by( 'email', $email ); 

		if( ($user)  && (!is_user_logged_in())) {

			$user_id = $user->ID;
			wp_set_current_user( $user_id, $user_login );
			wp_set_auth_cookie( $user_id );
			//do_action( 'wp_login', $user_login );

		}  

		$pay_url = $order->get_checkout_payment_url( $on_checkout = false );
		

		return new \WP_REST_Response( array(
				'success'   => true,
				'value'     => array(
					'redirect' => $pay_url
				)
		), 200 );
		
	}

	/**
	 * Endpoint add WC Subscription to user by email in params
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 * @return	mixed	$output		Output of the buffer
	 */

	public function fb_add_suscription_user( $request ) {

		$email_user = $request->get_param( 'email_user' );

		if (empty($email_user)) { 
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Empty data'
			), 403 );
		}

		$email_info = get_user_by( 'email', $email_user );
	  
		$customer_id = $email_info->ID;


		// First make sure all required functions and classes exist
		if( ! function_exists( 'wc_create_order' ) || ! function_exists( 'wcs_create_subscription' ) || ! class_exists( 'WC_Subscriptions_Product' ) ){
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error.'
			), 403 );
		}
	


		$firstname = get_user_meta( $customer_id, 'first_name', true );
		$lastname = get_user_meta( $customer_id, 'last_name', true );
		$address_1 = get_user_meta( $customer_id, 'billing_address_1', true ); 
		$address_2 = get_user_meta( $customer_id, 'billing_address_2', true );
		$city = get_user_meta( $customer_id, 'billing_city', true );
		$postcode = get_user_meta( $customer_id, 'billing_postcode', true );
		$country = get_user_meta( $customer_id, 'billing_country', true );
	
		$address         = array(
			'first_name' => $firstname,
			'last_name'  => $lastname,
			'email'      => $email_user,
			'address_1'  => $address_1,
			//'address_2'  => $address_2,
			'city'       => $city,
			//'state'      => $state,
			'postcode'   => $postcode,
			'country'    => $country,
		);

		$product_id = wc_get_product_id_by_sku('FBA01');
		$product = get_product( $product_id );

	
		$order->set_address( $address, 'billing' );
		$order->set_address( $address, 'shipping' );
		// $order->set_payment_method( 'stripe' );
		// $order->set_payment_method_title( 'Credit Card' );
		$order->add_product( $product, 1 );
	
		$sub = wcs_create_subscription(array(
			'order_id' => $order->get_id(),
			'customer_id'      => $customer_id,
			'status' => 'pending', // Status should be initially set to pending to match how normal checkout process goes
			'billing_period' => WC_Subscriptions_Product::get_period( $product ),
			'billing_interval' => WC_Subscriptions_Product::get_interval( $product ),
			'requires_manual_renewal' => false,
			'cancelled_email_sent'    => false
		));
	
		if( is_wp_error( $sub ) ){
			return new \WP_REST_Response( array(
				'success'   => false,
				'value'     => 'Error.'
			), 403 );
		}
	
		// Modeled after WC_Subscriptions_Cart::calculate_subscription_totals()
		$start_date = gmdate( 'Y-m-d H:i:s', '2020-07-24' );
		$sub->add_product($product, 1 );

		// $sub->set_payment_method( 'stripe' );
		// $sub->set_payment_method_title( 'Credit Card' );
		$sub->set_address( $address, 'billing' );
	
		$dates = array(
			'next_payment' => WC_Subscriptions_Product::get_first_renewal_payment_date( $product, $start_date ),
			'end'          => WC_Subscriptions_Product::get_expiration_date( $product, $start_date ),
		);
	
		$sub->update_dates( $dates );
		$sub->calculate_totals();
		$order->calculate_totals();
	
		// Update order status with custom note
		$note = ! empty( $note ) ? $note : __( 'Programmatically added by Frouzebox Plugin.' );
		$order->update_status( 'pending', $note, true );
		
	}

		/**
	 * Endpoint that check if an email exist in WP to validate by ajax
	 *
	 * @param   request	$request
	 * @return	WP_REST_Response http response
	 */

	public function fb_email_exists ( $request ) {

			if( is_email( $request[ 'email' ] ) && is_numeric( email_exists( $request[ 'email' ] ) ) ){
				return new \WP_REST_Response( array(
					'success'   => false,
					'message'     => __('Cet e-mail est déjà enregistré.', 'frouzebox-forms')
				), 403 );
			}

			return new \WP_REST_Response( array(
				'success'   => true,
				'value'     => $request[ 'email' ]
			), 200 );

		}
	



	
}