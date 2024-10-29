<?php 

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

if (isset($_GET['id'])){
	
	global $wpdb;
	$q_id = sanitize_text_field($_GET['id']);

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$table_name = $wpdb->prefix . "product_quote_request_detail";
	$question12 = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $current_user_id order by quote_ID desc");
	$count = 1;
	$array_count = array();
	foreach ($question12 as $value) {
		$array_count[$count] = $value->quote_ID; 
		$count++;
	}

	$table_name = $wpdb->prefix . "product_quote_request_detail";
	$question12 = $wpdb->get_results("SELECT * FROM $table_name where quote_ID = $q_id order by quote_ID desc ");

	foreach ($question12 as $value) {
		?>
		Request Quote <b>#<?php echo esc_html($q_id); ?></b> was placed on <b><?php echo esc_html($value->date); ?></b> and is currently <b><?php echo esc_html($value->status); ?></b>
		<h3>Request Quote Detail</h3>
		<table>
			<tr>
				<td><b>User Name</b></td>
				<td><?php echo esc_html($value->user_name); ?></td>
			</tr>
			<tr>
				<td><b>Product Name</b></td>
				<td>
					<a href="<?php echo esc_url(get_permalink($value->product_id)); ?>"><?php echo esc_html($value->product_name); ?></a></td>
			</tr>
			<tr>
				<td><b>Quantity</b></td>
				<td><span style="color: gray; font-size:10px;font-weight: 600;" >X &nbsp</span><?php echo esc_html($value->product_qty); ?></td>
			</tr>
			<tr>
				<td><b>Cost (Per Unit)</b></td>
				<td><?php

					$product = wc_get_product( $value->product_id );
					$price = $product->get_price(); 
					?>
					<b><?php echo esc_html(get_woocommerce_currency_symbol().$value->ex_price); ?>&nbsp(Expected cost)</b> &nbsp | &nbsp<?php echo esc_html(get_woocommerce_currency_symbol().$price); ?>&nbsp(Sale cost) 
					
				</td>
			</tr>
			<tr>
				<td><b>Status</b></td>
				<td><b><?php echo esc_html($value->status); ?></b></td>
			</tr>
			<tr>
				<td><b>Date</b></td>
				<td><?php echo esc_html($value->date); ?></td>
			</tr>
			<tr>
				<td><b>Message</b></td>
				<td><?php echo esc_html($value->user_message); ?></td>
			</tr>
			<tr>
				<td><b>Email</b></td>
				<td><?php echo esc_html($value->user_email); ?></td>
			</tr>
			<tr>
				<td><b>Phone</b></td>
				<td><?php echo esc_html($value->user_phone); ?></td>
			</tr>
		</table>
	<?php
	}

	$pre_key_temp = array_search($q_id,$array_count);

		$pre_key = $pre_key_temp - 1 ;
		$next_key = $pre_key_temp + 1 ;

	if ( (empty($array_count[$pre_key])) && (!empty($array_count[$next_key])) ) {
		?>
		<div style="width:50; float: left; text-align: left;"> <a href="" style="display:none;"><< Previous</a> </div><div style="width:50; text-align: right;"><a href="?id=<?php echo esc_attr($array_count[$next_key]); ?>"> Next >></a></div>
		<?php
	}

	if ( (empty($array_count[$next_key])) && (!empty($array_count[$pre_key])) ) {
		?>
		<div style="width:50; float: left; text-align: left;"> <a href="?id=<?php echo esc_attr($array_count[$pre_key]); ?>" ><< Previous </a> </div><div style="width:50; text-align: right;"><a href="" style="display:none;"> Next >></a></div>
		<?php
	}
	
	if ( (!empty($array_count[$pre_key])) && (!empty($array_count[$next_key])) )
	{
		?>
		<div style="width:50; float: left; text-align: left;"> <a href="?id=<?php echo esc_attr($array_count[$pre_key]); ?>" ><< Previous </a> </div><div style="width:50; text-align: right;"><a href="?id=<?php echo esc_attr($array_count[$next_key]); ?>"> Next >></a></div>
		<?php
	}

} 
else{
?>
	<div>
		<h3>My Product Quote</h3>
		<table class="p_q_table">
			<tr>

				<th>Quote</th>
				<th>Status</th>
				<th>Date</th>
				<th>Action</th>

			</tr>
			<?php 
				$current_user = wp_get_current_user();
				$current_user_id = $current_user->ID;

				global $wpdb;
				$table_name = $wpdb->prefix . "product_quote_request_detail";
				$question12 = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $current_user_id order by quote_ID desc ");

				if ( $question12 == false ) {
					?>
					<tr><td colspan='4'>
					<p style='color:red; text-align:center;'>* No Product Quotation Request Found.</p>
					</td></tr>
					<?php
				}
				else{
					foreach ($question12 as $value) {
						?>
						<tr>
							<td>#<?php echo esc_html($value->quote_ID); ?></td>
							<td><?php echo esc_html($value->status); ?></td>
							<td><?php echo esc_html($value->date); ?></td>
							<td style="width:150px;"><a href="?id=<?php echo esc_attr($value->quote_ID); ?>" class="button" style="width:100%;">View</a></td>
						</tr>
						<?php
					}
				}
			 ?>
		</table>
	</div>
<?php 
}
?>
