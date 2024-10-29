<?php 
/*Plugin Name: ASPL Product Quotation
	Plugin URI: https://acespritech.com/services/wordpress-extensions/
	Description: This plugin establishes a common communication for customers and suppliers where suppliers can share prices and details of a single product.
	Author: Acespritech Solutions Pvt. Ltd.
	Author URI: https://acespritech.com/
	Version: 1.1.0
	Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

/*Database Installer Hook*/
	function aspl_wpq_installer(){
	    include('product_quote_db.php');
	}
	register_activation_hook( __file__, 'aspl_wpq_installer' );
/*End*/

/*Create a Woocommerce End-Point*/
	function aspl_wpq_endpoints() {
	    add_rewrite_endpoint( 'product-quote', EP_ROOT | EP_PAGES );
	}

	add_action( 'init', 'aspl_wpq_endpoints' );

	function aspl_wpq_query_vars( $vars ) {
	    $vars[] = 'product-quote';

	    return $vars;
	}

	add_filter( 'query_vars', 'aspl_wpq_query_vars', 0 );

	function aspl_wpq_flush_rewrite_rules() {
	    flush_rewrite_rules();
	}

	add_action( 'wp_loaded', 'aspl_wpq_flush_rewrite_rules' );

	function aspl_wpq_my_product_quote_my_account_menu_items( $items ) {
	    $items = array(
	        'dashboard'         => __( 'Dashboard', 'woocommerce' ),
	        'orders'            => __( 'Orders', 'woocommerce' ),
	        'downloads'       => __( 'Downloads', 'woocommerce' ),
	        'edit-address'    => __( 'Addresses', 'woocommerce' ),
	        'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
	        'edit-account'      => __( 'Edit Account', 'woocommerce' ),
	        'product-quote'      =>__('Product Quote', 'woocommerce'),
	        'customer-logout'   => __( 'Logout', 'woocommerce' ),
	    );

	    return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'aspl_wpq_my_product_quote_my_account_menu_items' );

	function aspl_wpq_my_product_quote_endpoint_content() {

	    include 'user_request_data.php';
	    
	}
	add_action( 'woocommerce_account_product-quote_endpoint', 'aspl_wpq_my_product_quote_endpoint_content' );
/*End*/

/*Create a Admin Menu*/
	add_action('admin_menu', 'aspl_wpq_my_menu_product_quotation');
	function aspl_wpq_my_menu_product_quotation(){
	    $hook = add_menu_page('Product Quotation', 'Product Quotation', 'manage_options', 'Product_Quotation', 'product_quotation','dashicons-media-text' );
	     add_submenu_page( 
	        null,
	        'Product Quotation',
	        'Product Quotation',
	        'manage_options',
	        'my-custom-submenu-page-product-quotation',
	        'aspl_wpq_my_product_quotation_page_callback'
	    );

	    /*Pagination Hook*/
		add_action( "load-$hook", 'add_options' );
		
	}

	function add_options() {
		global $testListTable;
		$option = 'per_page';
		$args = array(
		        'label' => 'Request',
		        'default' => 10,
		        'option' => 'books_per_page'
		    );
		add_screen_option( $option, $args );
	}

	function aspl_wpq_set_screen_option($status, $option, $value)
	{
		if ( 'books_per_page' == $option ) return $value;
	}
	add_filter('set-screen-option', 'aspl_wpq_set_screen_option', 10, 3);

/*End*/

/*Quote Edit Page Callback Function*/
	function aspl_wpq_my_product_quotation_page_callback(){
		include 'quote_edit_page.php';
	}
	function product_quotation(){
		include 'product_quotation.php';
	}
/*End*/

/*Script Admin and User Side*/

	/*User Side*/
		function aspl_wpq_my_load_scripts_user($hook) {
		   
		    wp_enqueue_script( 'custom_quote_js', plugin_dir_url(__FILE__) . 'js/custom.js',array('jquery')); 
		}
		add_action('wp_enqueue_scripts', 'aspl_wpq_my_load_scripts_user');

		function aspl_wpq_userscript(){
		  wp_enqueue_style('aspl_wqp_user-styles', plugin_dir_url(__FILE__) . 'css/wpq_custom_user_css.css');
		}
		add_action('wp_enqueue_scripts', 'aspl_wpq_userscript');
	/*End*/
	/*Admin Side*/
		function aspl_wpq_my_load_scripts_admin($hook) {
			wp_enqueue_script("jquery");
			wp_enqueue_script('custom_quote_js1', plugin_dir_url(__FILE__) . 'js/custom.js', array('jquery'), '', true);
		}
		add_action('admin_enqueue_scripts','aspl_wpq_my_load_scripts_admin');

		function aspl_wpq_admin_style() {
		  wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__) . 'css/wpq_custom_css.css');
		}
		add_action('admin_enqueue_scripts', 'aspl_wpq_admin_style');
	/*End*/

/*End*/
/*Create Product Tab*/

	function aspl_wpq_custom_product_tabs_quotation($tabs12){
		$tabs12['ASPL_quotation'] = array(
			'label' => __('ASPL Quotation', 'woocommerce12'),
			'target' => 'aspl_quotation',
			'class' => array('show_if_simple', 'show_if_variable'),
		);
		return $tabs12;
	}
	add_filter('woocommerce_product_data_tabs','aspl_wpq_custom_product_tabs_quotation');

	function aspl_wpq_options_product_tab_content_quotation(){
				
		global $post;
		
		?>
			
		<div id='aspl_quotation' class='panel woocommerce_options_panel'>
			<div class='options_group'>
				<div>
					<h1>&nbsp Product Quotation Configure</h1>
				</div>
				<div>
					<?php 
						woocommerce_wp_radio( array(
							'id'            => '_input_radio',
							'wrapper_class' => 'show_if_simple',
							'label'         =>  __('Display With'),
							'description'   =>  __( 'Select Option for display add-to-Quote with different way.' ).'<br>',
							'options'       =>  array(
									            'with_cart'       => __('Add-to-Quote Button With Add-to-cart Button'),
									            'with_quote'       => __('Add-to-Quote Button Without Add-to-cart Button'),
									            'default'       => __('Default'),
									        )
						) );
					?>
				</div>
			</div>
		</div>

		<?

	}
	add_filter('woocommerce_product_data_panels','aspl_wpq_options_product_tab_content_quotation');


	function aspl_wpq_save_giftcard_product_quotation_option_fields( $post_id ) {

		$wc_radio = isset( $_POST['_input_radio'] ) ? $_POST['_input_radio'] : '';
	    update_post_meta( $post_id, '_input_radio', $wc_radio );

	}
	add_action( 'woocommerce_process_product_meta_simple', 'aspl_wpq_save_giftcard_product_quotation_option_fields'  );
	add_action( 'woocommerce_process_product_meta_variable', 'aspl_wpq_save_giftcard_product_quotation_option_fields'  );

/*End*/

/*Add Quote Button and Remove Add-to-cart Button in Product Page*/

	add_action( 'woocommerce_single_product_summary', 'aspl_wpq_cfwc_display_custom_field' );

	function aspl_wpq_cfwc_display_custom_field() {
		global $post;
		global $product;
		$output ='';
		$wc_setting_check_quote = get_option( 'aspl_quote_auto_insert' );

		if ($wc_setting_check_quote == 'add_to_quote') {

			if (is_product()) {

				$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data
				
				if ($radio == 'with_cart') {
				   	global $product;
					$id = $product->get_id();
				    include 'pop_up.php';	
			    }else if($radio == 'default'){

			    }else{        	
			    	global $product;
					$id = $product->get_id();
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
					include 'pop_up.php';
			    }

			}

		}else if($wc_setting_check_quote == 'add_to_quote_and_cart'){

			if (is_product()) {

				$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data
				if ($radio == 'with_quote') {
				    global $product;
					$id = $product->get_id();
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
			    	include 'pop_up.php';
				}else if($radio == 'default'){

		    	}else{
				    global $product;
					$id = $product->get_id();
					include 'pop_up.php';	
				}

			}

		}else{

			$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

			if( ! empty( $radio ) ){

				if ($radio == 'with_cart') {
				   	if (is_product()) {
				   		global $product;
						$id = $product->get_id();
				       	include 'pop_up.php';	
				   	}
			    }
			    if ($radio == 'with_quote') {
			    	if (is_product()) {
					    global $product;
						$id = $product->get_id();
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
				    	include 'pop_up.php';
				    }
				}
				if ($radio == 'default') { }

			}
			_e($output);

		}
	}
/*End*/

/*Add Coundition for Shop Page*/

	add_action( 'woocommerce_before_shop_loop_item', 'aspl_wpq_western_custom_buy_buttons');	
	function aspl_wpq_western_custom_buy_buttons(){

	   	// $product = get_product();
		global $post;
		$wc_setting_check_quote = get_option( 'aspl_quote_auto_insert' );

	 	if ($wc_setting_check_quote == 'add_to_quote') {

	 		$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_cart' ){
				add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	}else if($radio == 'default'){
				add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	} else {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	}

	 	}else if($wc_setting_check_quote == 'add_to_quote_and_cart'){

	 		$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_quote' ){
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	} else {
				add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	}


	 	}else{

			$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_quote' ){
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	}
		   	else{
				add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		   	}
	 	}

	}
/*End*/

/*Add View-Product Button in Shop Page*/

	add_action( 'woocommerce_after_shop_loop_item', 'aspl_wpq_quote_btn');	
	function aspl_wpq_quote_btn(){
		
		global $post;
		global $product;

		$wc_setting_check_quote = get_option( 'aspl_quote_auto_insert' );

	 	if ($wc_setting_check_quote == 'add_to_quote') {

	 		$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_cart' ){

		   	} else if($radio == 'default'){

		   	}else{

				global $product;
				$link = $product->get_permalink();
				?>
				<a href="<?php echo esc_attr($link); ?>" class="button addtocartbutton">View Product</a>
		   		<?php

		   	}

	 	} else if($wc_setting_check_quote == 'add_to_quote_and_cart'){

	 		$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_quote' ){

			   	global $product;
				$link = $product->get_permalink();
				?>
				<a href="<?php echo esc_attr($link); ?>" class="button addtocartbutton">View Product</a>
				<?php	

			}

	 	} else {

			$radio = get_post_meta( $post->ID, '_input_radio', true ); // Get the data

		   	if ( $radio == 'with_quote' ){

			   	global $product;
				$link = $product->get_permalink();
				?>
				<a href="<?php echo esc_attr($link); ?>" class="button addtocartbutton">View Product</a>
				<?php

			}

	 	}
	
	}
/*End*/

/*Ajax Callback Function for Request Popup Button */
	add_action('wp_ajax_aspl_wpq_fuction_add_request_data', 'aspl_wpq_fuction_add_request_data');
	add_action('wp_ajax_nopriv_aspl_wpq_fuction_add_request_data', 'aspl_wpq_fuction_add_request_data');
	function aspl_wpq_fuction_add_request_data(){

		$product_id = sanitize_text_field($_POST['product_id']);
		$Product_name = sanitize_text_field($_POST['Product_name']);
		$product_qty = sanitize_text_field($_POST['product_qty']);
		$product_exprice = sanitize_text_field($_POST['product_exprice']);
		$user_id = sanitize_text_field($_POST['user_id']);
		$user_name = sanitize_text_field($_POST['user_name']);
		$user_phone = sanitize_text_field($_POST['user_phone']);
		$user_email = sanitize_text_field($_POST['user_email']);
		$user_message = sanitize_text_field($_POST['user_message']);
		$date = date("F d \, Y");
		$status = "New";

		global $wpdb;
		$table_name1 = $wpdb->prefix . "product_quote_request_detail";
		$q = $wpdb->insert($table_name1, array(
				    'product_id' => $product_id,
				    'Product_name' => $Product_name,
				    'product_qty' => $product_qty, // ... and so on
				    'user_id' => $user_id,
				    'user_name' => $user_name,
				    'user_phone' => $user_phone,
				    'user_email' => $user_email,
				    'user_message' => $user_message,
				    'date' => $date,
				    'status' => $status,
				    'ex_price' => $product_exprice
				));

		$jsonarray = 'done';
		$myJSON = json_encode($jsonarray);
		_e($myJSON);
		die();

	}
/*End*/

/*Ajax Callback Function for Update Quote Request Data By Admin in Update Page*/
add_action('wp_ajax_aspl_wpq_fuction_update_status', 'aspl_wpq_fuction_update_status');
add_action('wp_ajax_nopriv_aspl_wpq_fuction_update_status', 'aspl_wpq_fuction_update_status');
function aspl_wpq_fuction_update_status(){

	$status = sanitize_text_field($_POST['status']);
	$quote_id = sanitize_text_field($_POST['quote_id']);

	global $wpdb;

	$table_name = $wpdb->prefix . "product_quote_request_detail";

 	$execut= $wpdb->get_results(" UPDATE $table_name SET status = '$status' WHERE quote_ID = $quote_id ");

	$blog_title = get_bloginfo( 'name' );
	$msg_data = $wpdb->get_results("SELECT * FROM $table_name where quote_ID = $quote_id");

	foreach ($msg_data as $temp) {
		$message = 'Hello, ' . $temp->user_name . ' Your #'. $quote_id .' quotation request \'' . $status . '\'.Please check your product quote detail in account page.';
		$user_email = $temp->user_email;
	}

	$email = get_option('admin_email');
	$to = $user_email;
	$subject = "Quotation Request " . $status ;
	$headers =  'From: '.$blog_title.' <'.$email.">\r\n" .'Reply-To: ' . $email . "\r\n";
	$sent = wp_mail($to, $subject, strip_tags($message), $headers);

	if ( $sent == 'true') {
	 	$jsonarray = '1';
		$myJSON = json_encode($jsonarray);
		_e($myJSON);
		die();
	}else{
	 	$jsonarray = '0';
		$myJSON = json_encode($jsonarray);
		_e($myJSON);
		die();
	}

}
/*End*/

/*Ajax Callback Function for Delete Quote Request Data/Record */
	add_action('wp_ajax_aspl_wpq_fuction_delete_quote_btn', 'aspl_wpq_fuction_delete_quote_btn');
	add_action('wp_ajax_nopriv_aspl_wpq_fuction_delete_quote_btn', 'aspl_wpq_fuction_delete_quote_btn');
	function aspl_wpq_fuction_delete_quote_btn(){

		$quote_id = sanitize_text_field($_POST['quote_id']);
		global $wpdb;

		$table_name = $wpdb->prefix . "product_quote_request_detail";

		$execut= $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE quote_ID = %s", $quote_id ) );
		
		$jsonarray = get_admin_url().'admin.php?page=Product_Quotation';;
		$myJSON = json_encode($jsonarray);
		_e($myJSON);
		die();
	}

	add_filter('views_toplevel_page_subscribers','my_plugin_slug_status_links',10, 1);

	function my_plugin_slug_status_links($views) {
	   $views['scheduled'] =  "<a href='#'>Scheduled</a>";
	   return $views;
	}
/*End*/

/**
 * Create the Section in Setting the Products Tab
 **/

	add_filter( 'woocommerce_get_sections_products', 'aspl_wpq_quote_add_section' );
	function aspl_wpq_quote_add_section( $sections ) {
		
		$sections['aspl_quote'] = __( 'Woocommerce Quote', 'woocommerce-quote' );
		return $sections;
		
	}

	add_filter( 'woocommerce_get_settings_products', 'aspl_wpq_quote_all_settings', 10, 2 );
	function aspl_wpq_quote_all_settings( $settings, $current_section ) {
		/**
		 * Check the current section is what we want
		 **/
		if ( $current_section == 'aspl_quote' ) {

			$settings_quote = array();
			
			$settings_quote[] = array( 'name' => __( 'Woocommerce Quote Settings', 'woocommerce-quote' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Woocommerce Product Quotation', 'woocommerce-quote' ), 'id' => 'aspl_quote' );
			
			// Add first checkbox option
			$settings_quote[] = array(
				'name'     => __( 'Insert Woocommerce Product Quotation Option for All Product', 'woocommerce-quote' ),
				'desc_tip' => __( 'This will automatically insert Product Quotation option in product detail page', 'woocommerce-quote' ),
				'id'       => 'aspl_quote_auto_insert',
				'default' => 'default',
				'type'     => 'radio',
				'css'      => '',
				'desc'     => __( 'Select Option for All Product ', 'woocommerce-quote' ),
				'options' => array(
				      'default'        => __( 'Default', 'woocommerce-quote' ),
				      'add_to_quote'       => __( 'Add to Quote', 'woocommerce-quote' ),
				      'add_to_quote_and_cart'  => __( 'Add to Quote and Cart', 'woocommerce-quote' )
				    ),
				 
			);

			$settings_quote[] = array( 'type' => 'sectionend', 'id' => 'aspl_quote' );

			return $settings_quote;

		} else {
			return $settings;
		}
		/*End*/
	}

/*End*/

