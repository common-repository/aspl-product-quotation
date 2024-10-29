<?php 

  if ( ! defined( 'ABSPATH' ) ) 
  {
    exit;
  }
  
?>

<button id="myBtn" style="margin-bottom: 10px;">Add To Quote</button>
<div class="aspl_popup">
    <div id="myModal" class="modal myModal">
        <div class="modal-content req_popup_parent">
    		<?php 
    			global $product;
    			$id = $product->get_id();
    		?>
        	<span class="close">&times;</span>
         	<h6>Send the request</h6>
    		<table style="width:100%; text-align: center;" class="table_product_popup">
    			<tr>
    				<td>Image</td>
    				<td>Name</td>
    		 		<td>Qty</td>
    		 		<td>Expected price(per unit)<br>(in <?php echo esc_html(get_woocommerce_currency_symbol()); ?>) </td>
    		 	</tr>
    		 	<tr>
    		 		<input type="hidden" name="" class="p_id" value="<?php echo esc_attr($id); ?>">
    		 		<td><img src="<?php echo esc_attr(wp_get_attachment_url( $product->get_image_id() )); ?>" width="50px"/></td>
    		 		<td>
                        <span class="req_popup_p_name"><?php echo esc_html($product->get_name()); ?></span>
                    </td>
    		 		<td>
                        <center>
                            <input type="number" name="" style="width:150px;" class="req_popup_p_qty" value="1">
                        </center> 
                    </td>
    		 		<td>
                        <center>
                            <input type="number" name="" class="req_popup_p_exprice" style="width:100px;" value="<?php echo esc_attr($product->get_price()); ?>" max ="<?php echo esc_attr($product->get_price()); ?>">
                        </center>
                    </td>
    		 	</tr>
    		</table>

            <input type="hidden" name="" class="ajaxurl" value="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">

        	<lable for="popup_name"> Name </lable>
        	<input type="text" id="popup_name" value="<?php 
    			$user = wp_get_current_user();
    			echo esc_attr($user->display_name);
                ?>" class="req_popup_user_name"><br>
    	     
            <input type="hidden" name="user_id" class="popup_user_id" value="<?php echo esc_attr($user->ID);?>"> 

        	<lable for="popup_email"> Email </lable>
    		<input type="email" id="popup_email" value="<?php 
    			echo esc_attr($user->user_email);?>" class="popup_user_email" ><br>

    		<lable for="popup_phone"> Phone Number </lable>
    		<input type="number" id="popup_phone" class="popup_user_phone"><br>

    		<label> Message </label>
    		<textarea class="popup_request_message"></textarea><br>
    		<?php 
    			if (is_user_logged_in()) {
    				?><button class="pop_up_request_btn">Send Your Request</button><?
    			}
    			else {
    				?><span style="color:red;"><SUP>* </SUP>Please login to Send Request.</span><?
    			}
    		?>
        </div>
    </div>
</div>

<script>

    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        
        if (event.target == modal) {
            modal.style.display = "none";
        }

    }

</script>

