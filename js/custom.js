jQuery(document).ready(function($){

	$(document).on("click", ".pop_up_request_btn" , function() {
		
		var product_id = $(this).parents(".req_popup_parent").find(".p_id").val();
		var product_name = $(this).parents(".req_popup_parent").find(".req_popup_p_name").text();
		var product_qty = $(this).parents(".req_popup_parent").find(".req_popup_p_qty").val();
		var product_exprice = $(this).parents(".req_popup_parent").find(".req_popup_p_exprice").val();
		var user_name = $(this).parents(".req_popup_parent").find(".req_popup_user_name").val();
		var user_id = $(this).parents(".req_popup_parent").find(".popup_user_id").val();
		var user_email = $(this).parents(".req_popup_parent").find(".popup_user_email").val();
		var user_phone = $(this).parents(".req_popup_parent").find(".popup_user_phone").val();
		var user_message = $(this).parents(".req_popup_parent").find(".popup_request_message").val();
		var ajaxurl = $(this).parents(".req_popup_parent").find(".ajaxurl").val();
		var th = $(this);

		if ( product_qty != '' && user_name != '' && user_email != '' && user_phone != '' && user_message != '' ) {

			$.ajax({    
	                type: "POST",
	                dataType: "json",
	                url: ajaxurl,
	                data: {
	                    action: 'aspl_wpq_fuction_add_request_data',
	                    product_id   : product_id,
	                    Product_name : product_name,
	                    product_qty  : product_qty,
	                    user_name    : user_name,
	                    user_id      : user_id,
	                    user_email 	 : user_email,
	                    user_phone   : user_phone,
	                    user_message : user_message,
	                    product_exprice:product_exprice,
	                },
	                success: function (data) {
						$(th).parents(".myModal").css("display", "none");
	                	alert("We Will Contact You Soon. Thankyou.");
	                }
        	});

		}else{
			alert("Request is not send! Please fill all detail.");
		}

	});

	$(document).on("click", ".wqp_update_request_data" , function() {

		var	status_data =  $(".wpq_select_stsatus").val();
		var	quote_id =  $(".wpq_hidden_request_id").val();

		$.ajax({    
		    type: "POST",
	        dataType: "json",
	        url: ajaxurl,
	        data: {
	            action: 'aspl_wpq_fuction_update_status',
	            status : status_data,
	            quote_id : quote_id,
	        },
	        beforeSend: function() {
			            $(".loading").show();
			        },
	        success: function (data) {
	        	$(".loading").hide();
	        	if (data == "1") {
	        		alert("Data Updated Successfully.User Get Email For this.");
	        	}else{
	        		alert("Data Updated successfully.But Somthing Want to Worng With Your Mail Server! User Don't Get Email For This.");
	        	}
	        }
        });

	});

	$(document).on("click", ".wqp_delete_request_data" , function() {
		
		alert("Delete");
		var	quote_id =  $(".wpq_hidden_request_id").val();
		$.ajax({    
		    type: "POST",
	        dataType: "json",
	        url: ajaxurl,
	        data: {
	            action: 'aspl_wpq_fuction_delete_quote_btn',
	            quote_id : quote_id,
	        },
	        success: function (data) {
	        	window.location.href = data;
	        }
        });

	});

});