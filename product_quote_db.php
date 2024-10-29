<?php 

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}
	
global $wpdb;
$table_name = $wpdb->prefix . "product_quote_request_detail";
// $my_products_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            `quote_ID` mediumint(9) NOT NULL AUTO_INCREMENT,
            `product_id` mediumint(9) NOT NULL,
            `product_name` text NOT NULL,
            `product_qty` mediumint(9) NOT NULL,
            `user_id` mediumint(9) NOT NULL,
            `user_name` text NOT NULL,
            `user_phone` text NOT NULL,
            `user_email` text NOT NULL,
            `user_message` text NOT NULL,
            `date` text NOT NULL,
            `status` text NOT NULL,
            `ex_price` text NOT NULL,
            PRIMARY KEY  (quote_ID)
    )$charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    // add_option( my_db_version', $my_products_db_version );
}


 ?>