<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap"> 

    <?php  ?>
    <h2><?php esc_html_e('Edit Quote Request','domain'); ?></h2>
    <form name="my_form" method="post">
        <input type="hidden" name="action" value="some-action">
        <?php 
	        wp_nonce_field( 'some-action-nonce' );
	        wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
	        wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); 
	    ?>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-<?php echo esc_attr(1 == get_current_screen()->get_columns() ? '1' : '2'); ?>">
                <div id="post-body-content" style="background-color: white; border:1px solid #ccd0d4;">

					<?php 
						global $wpdb;
						$quote_id = sanitize_text_field($_GET['id']);
			            $table_name = $wpdb->prefix . "product_quote_request_detail";
			            $question12 = $wpdb->get_results("SELECT * FROM $table_name where quote_ID = $quote_id");

			            foreach ($question12 as $temp) {
			            	?>
			            	<h2 style="border-bottom:1px solid #ccd0d4;">Quote Request #<?php echo esc_html($temp->quote_ID); ?>details</h2>

			            	<div class="panel-wrap woocommerce">
				            	<h2>General</h2>
				            	<div class="panel woocommerce-order-data">
				            		<table style="padding: 20px 20px;width: 50%;">
				            			<tr>
				            				<td><label>User name </label></td>
				            				<td>:</td>
				            				<td style=" padding-top: 10px; padding-bottom: 10px; ">
				            					<span style="width:50%;  padding: 10px; border-radius: 4px; background-color: #eee; ">
				            						<?php echo esc_html($temp->user_name); ?>
				            					</span>&nbsp &nbsp 
				            					<a href="<?php echo esc_url(get_home_url()); ?>/wp-admin/user-edit.php?user_id=<?php echo esc_attr($temp->user_id); ?>">Profile →</a>
				            				</td>
				            			</tr>
				            			<tr>
				            				<td><label>Message </label></td>
				            				<td>:</td>
				            				<td style=" padding-top: 10px; padding-bottom: 10px; ">
				            					<span style="width:100%;  padding: 10px; border-radius: 4px; background-color: #eee; ">
				            						<?php  echo esc_html($temp->user_message);?>
				            					</span>
				            				</td>
				            			</tr>
				            			<tr>
				            				<td><label>Status</label></td>
				            				<td>:</td>
				            				<td>
				            					<?php $status = $temp->status; ?>
						            			<select style="width:100%;" class="wpq_select_stsatus">
							            			<option value="New" <?php 
							            				if ( $status == 'New' )
							            					{
							            						echo esc_attr('selected');
							            					} 
							            			?>>New</option>
							            			<option value="Processing" <?php 
							            				if ( $status == 'Processing' )
							            					{
							            						echo esc_attr('selected');
							            					} 
							            			?>>Processing</option>
							            			<option value="On hold" <?php 
							            				if ( $status == 'On hold' )
							            					{
							            						echo esc_attr('selected');
							            					} 
							            			?>>On hold</option>
							            			<option value="Approve" <?php 
							            				if ( $status == 'Approve' )
							            					{
							            						echo esc_attr('selected');
							            					} 
							            			?>>Approve</option>
							            			<option value="Cancelled" <?php 
							            				if ( $status == 'Cancelled' )
							            					{
							            						echo esc_attr('selected');
							            					} 
							            			?>>Cancelled</option>
						            			</select>
						            			<input type="hidden" name="" class="wpq_hidden_request_id" value="<?php echo esc_attr($temp->quote_ID); ?>" >
						            		</td>
				            			</tr>
				            			<tr>
				            				<td>Email address</td>
				            				<td>:</td>
				            				<td><a href="<?php echo esc_attr('mailto:'.$temp->user_email); ?>"><?php echo esc_html($temp->user_email); ?></a></td>
				            			</tr>
				            			<tr>
				            				<td>Phone</td>
				            				<td>:</td>
				            				<td>
				            					<a href="<?php echo esc_attr('tel:'.$temp->user_phone); ?>">
				            						<?php echo esc_html($temp->user_phone); ?>
				            					</a>
				            					<div class='loading'style='display:none;'></div>
				            				</td>
				            			</tr>
				            		</table>
				            	</div>
			            	</div>
			            	<?php
			            }
					 ?>
                </div>

                <div id="postbox-container-1" class="postbox-container" style="background-color: white; border:1px solid #ccd0d4; ">
                    <div style="width:100%;border-bottom: 1px solid #ccd0d4; ">
						<h2 style="width: 100%; padding-left: 10px;">Request Action</h2>
                    </div>
                    <div style="padding: 10px;">
	                    <table style="width:100%;">
	                    	<tr>
	                    		<td colspan="2"><label>Create at :</label></td>
	                    	</tr>
	                    	<tr >
	                    		<td colspan="2"><input type="text" name="" value="<?php echo esc_attr($temp->date); ?>" style="width:100%;" class="pq_read_only_input" readonly ></td>
	                    	</tr>
	                    	<tr>
	                    		<td>
	                    			<span style="color: #0073aa;text-decoration:underline;cursor: pointer;" class="wqp_delete_request_data">Move to trash</span>
	                    		</td>
	                    		<td style="text-align: right;">
	                    			<span name="" class="button button-primary wqp_update_request_data">Update</span>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    	</tr>
	                    </table>
                    </div>
                </div>

             	<div id="post-body-content" style="background-color: white;  border:1px solid #ccd0d4;">
					<?php 
						global $wpdb;
						$quote_id = sanitize_text_field($_GET['id']);
			            $table_name = $wpdb->prefix . "product_quote_request_detail";
			            $question12 = $wpdb->get_results("SELECT * FROM $table_name where quote_ID = $quote_id");

			            foreach ($question12 as $temp) {
			            	?>
			            	<h2 style="border-bottom:1px solid #ccd0d4;">Item</h2>
			            	<div class="panel-wrap woocommerce">
				            	<div class="panel woocommerce-order-data">
				            		<table style="width: 100%; padding: 10px;">
				            			<tr style="background-color: #f8f8f8;text-align: left; color: #999;">
				            				<th style="padding: 1em;">Item</th>
				            				<th  style="padding: 1em;">Cost</th>
				            				<th  style="padding: 1em;">Qty</th>
				            				<th  style="padding: 1em;">Total</th>
				            			</tr>
				            			<tr>
				            				<?php 
				            					$product_id = $temp->product_id;
				            					$attachment_ids[0] = get_post_thumbnail_id( $product_id );
				                                $attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' );
				                                $product = wc_get_product( $product_id );
				            				?>
			            					<td>
			            						<div class="wc-order-item-thumbnail" style="max-height: 80px; max-width: 100px; float: left;">
			            							
			            							<img src="<?php echo esc_url($attachment[0]); ?>" style="width: 80px; height: 80px; border: 2px solid lightgray;"> 
			            						</div>
			            						<div style="float:left;">
			            							<h2><a href="<?php echo esc_url(get_edit_post_link($product_id)); ?>"><?php echo esc_html($temp->product_name);  ?> </a></h2>
			            							<h2>SKU : <?php echo esc_html($product->get_sku($product_id)); ?> </h2>
			            						</div>
			            					</td>
			            					<td style="padding: 1em;"><?php
			            						$price = $product->get_price();
			            						$price1 = (int)$price;
			            						echo esc_html(get_woocommerce_currency_symbol().number_format($price1, 2, '.','')); 
			            					?></td>
			            					<td><span style="color: gray; font-size:10px;font-weight: 600;">X</span> <?php echo $temp->product_qty; ?></td>
			            					<td> <?php 
			            					$sub_total = $temp->product_qty * $product->get_price();
			            					echo esc_html(get_woocommerce_currency_symbol().number_format($sub_total, 2, '.','')); ?></td>
			            				</tr>
				            			</tr>
				            			<tr style="background-color: #f8f8f8;text-align: left; color: #999;">
				            				<th style="background-color: white;"></th>
				            				<th style="padding: 1em;">Expected cost</th>
				            				<th>Qty</th>
				            				<th>Expected Total</th>
				            			</tr>
				            			<tr>
				            				<td></td>
				            				<td style="padding: 1em;"><?php 
				            					$price = $temp->ex_price;
				            					$price1 = (int)$price;
				            					echo esc_html(get_woocommerce_currency_symbol().number_format($price1, 2, '.','')); ?></td>
				            				<td><span style="color: gray; font-size:10px;font-weight: 600;">X</span> <?php echo $temp->product_qty; ?></td>
				            				<td><?php 
				            					$sub_total = $temp->product_qty * $temp->ex_price;
				            					echo esc_html(get_woocommerce_currency_symbol().number_format($sub_total, 2, '.','')); ?>
				            				</td>
				            			</tr>
				            		</table>
				            	</div>
			            	</div>
			            	<?php
			            }
					 ?>
                </div>
            </div> <!-- #post-body -->
        </div> <!-- #poststuff -->
    </form>
 
</div><!-- .wrap -->
<?php 
	function show_option( $title, $option ) {
		$screen    = get_current_screen();
		$id        = "wordpress_screen_options_demo_$option";
		$user_meta = get_usermeta( get_current_user_id(), 'wordpress_screen_options_demo_options' );

		if ( $user_meta ) {
			$checked = array_key_exists( $option, $user_meta );
		} else {
			$checked = $screen->get_option( $id, 'value' ) ? true : false;
		}
		?>
			<label for="<?php echo esc_textarea( $id ); ?>">
				<input type="checkbox" 
				       name="wordpress_screen_options_demo[<?php echo esc_textarea( $option ); ?>]" 
				       class="wordpress-screen-options-demo" 
				       id="<?php echo esc_textarea( $id ); ?>" 
				       <?php checked( $checked ); ?>
				/> 
				<?php echo esc_html( $title ); ?>
			</label>
		<?php
	}
?>