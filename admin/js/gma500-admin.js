jQuery(document).ready(function() {
console.log(ajaxurl);


///////////////////////////////////////////////////////////////////////////////////
// PAGE REDIRECTIONS
///////////////////////////////////////////////////////////////////////////////////
	//Reload page with gma500_admin_addproduct_page action
    jQuery('#gma500-admin-main-submit-add-product-page-button').click(function() {
		jQuery('#gma500-admin-main-submit-add-product-page-form').submit();
	});

	//Update product item
	jQuery('#gma500-admin-product-details-update-button').click(function() {
		jQuery('#gma500-admin-product-details-update-form').submit();
	});

///////////////////////////////////////////////////////////////////////////////////
// ADD PRODUCT
///////////////////////////////////////////////////////////////////////////////////
	jQuery('#gma500-back-to-admin-button').click(function() {
		jQuery('#gma500-back-to-main-form').submit();
	});
	jQuery('#gma500-form-add-update-product').validate();

	//Form reset
	jQuery('#gma500-reset-add-product').click(function() {
		jQuery('#gma500-reset-add-product-form').submit();
	});
	//Product submit   
	jQuery('#gma500-submit-add-product').click(function() {
		if (jQuery('#gma500-form-add-update-product').valid()) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
						"action": "gma500_admin_addproduct",
						"idGMA" : jQuery('#idGMA').val(),
						"cathegory" : jQuery('#cathegory').val(),
						"brand" : jQuery('#marque').val(),
						"utilization" : jQuery('#utilization').val(),
						"serialNumber" : jQuery('#serialNumber').val(),
						"doc" : jQuery('#doc').val(),
						"isEPI" : jQuery('#epi').val(),
						"location" : jQuery('#location').val(),
						"description" : jQuery('#description').val(),	
						"image" : jQuery('#imagebase64').val(),
						"isRental" : jQuery('#isRental').val(),
						"bought" : jQuery('#bought').val(),																																									
					  },
				success: function(data) {
					console.log(data);
					var result = JSON.parse(data);
					if (result.error != null) {						
						jQuery('#gma500-add-product-ajax-result').html(result.error).removeClass('gma500-ajax-success').addClass('gma500-ajax-error').fadeIn();
					}
					if (result.success != null) {
						jQuery('#gma500-add-product-ajax-result').html(result.success).removeClass('gma500-ajax-error').addClass('gma500-ajax-success').fadeIn().delay(5000).fadeOut();
					}
				}
			}).fail(function(err) {
				jQuery('#gma500-add-product-ajax-result').html("Une erreur est survenue").addClass('gma500-ajax-error');
			});		
		}
	});	


	//Handle image with base64
	// imagebase64 is a hidden input that contains the value that will be send for storing
	//		it can be the default or the base64 string after processing
	jQuery('#imagebase64').val("../wp-content/plugins/gma500/admin/assets/default-product.jpg");
	
	//When we enter here we might have a default image or a base64 input in the case of update PRODUCT
	//We now init the canvas with the base64 if we have
	if (jQuery('#productImage').length != 0) {
		//Check if is base64 or file... if is base
		if (jQuery('#productImage')[0].src.match(';base64,')) {
			var canvas = jQuery('#shadowCanvas')[0];
			canvas.width=150;
			canvas.height=150;
			var ctx =canvas.getContext('2d');
			var image = new Image();
			image.onload = function() {
				ctx.drawImage(image, 0, 0);
				var real = jQuery('#productImage')[0];
				$base64 = canvas.toDataURL('image/jpeg', 0.9);
				real.src = $base64;
				jQuery('#imagebase64').val($base64);
				jQuery('#rotate').show();
				jQuery('#clear').show();
			};
			image.src = jQuery('#productImage')[0].src;
	    } 
	}


	jQuery('#rotate').hide();
	jQuery('#clear').hide();
	jQuery('#clear').on('click', function() {
		jQuery('#productImage')[0].src = "../wp-content/plugins/gma500/admin/assets/default-product.jpg";
		jQuery('#rotate').hide();
		jQuery('#clear').hide();
		jQuery('#imagebase64').val("../wp-content/plugins/gma500/admin/assets/default-product.jpg");
		var canvas = jQuery('#shadowCanvas')[0];
		var ctx =canvas.getContext('2d');
		ctx.clearRect(0,0,canvas.width, canvas.heigth);
	});
	//Handle upload image
	jQuery('#upload').on('click', function() {
		jQuery('#fileInput').click();
	});
	jQuery('#fileInput').on('change', function(event) {
		if(event.target.files && event.target.files.length) {			
			var reader = new FileReader();
			var file = event.target.files[0];
			reader.readAsDataURL(file);
			reader.onloadend = () => {
			  //Resize and crop image to 200x200
			  var destSize = 150;
			  var myImageData = new Image();
			  myImageData.src = reader.result;
			  var canvas = jQuery('#shadowCanvas')[0];
			  var ctx =canvas.getContext('2d');
			  myImageData.onload = function () {
				var sourceSize;
				var sourceWidth = myImageData.width;
				var sourceHeight = myImageData.height;
				if (sourceWidth>=sourceHeight) {
					var sourceX = (sourceWidth - sourceHeight)/2;
					var sourceY = 0;
					sourceSize=sourceHeight;
				} else {
					var sourceX = 0;
					var sourceY = (sourceHeight - sourceWidth)/2;
					sourceSize=sourceWidth;
				}
				canvas.width = destSize;
				canvas.height= destSize;
				ctx.clearRect(0,0,canvas.width, canvas.heigth);
				ctx.drawImage(myImageData, sourceX,sourceY, sourceSize, sourceSize, 0, 0, destSize,destSize);
				var real = jQuery('#productImage')[0];
				$base64 = canvas.toDataURL('image/jpeg', 0.9);
				real.src = $base64;
				jQuery('#imagebase64').val($base64);
				jQuery('#rotate').show();
				jQuery('#clear').show();
				console.log("Length is: " + canvas.toDataURL('image/jpeg', 0.9).length);
			  }
			};
		};		
	});
	jQuery('#rotate').on('click', function(event) {
		var angle = Math.PI / 2;
		var canvas = jQuery('#shadowCanvas')[0];
		var ctx =canvas.getContext('2d');
		var myImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
		myImageData = new Image();
		myImageData.src = canvas.toDataURL();
		myImageData.onload = function () {
		  var cw = canvas.width;
		  var ch = canvas.height;
		  ctx.save();
		  // translate and rotate
		  ctx.translate(cw, ch / cw);
		  ctx.rotate(angle);
		  // draw the previows image, now rotated
		  ctx.drawImage(myImageData, 0, 0);   
		  var real = jQuery('#productImage')[0];
		  $base64 = canvas.toDataURL('image/jpeg', 0.9);
		  real.src = $base64;
		  jQuery('#imagebase64').val($base64);		  
		  ctx.restore();
		  // clear the temporary image
		  myImageData = null;       
		}		

	});

///////////////////////////////////////////////////////////////////////////////////
// UPDATE PRODUCT
///////////////////////////////////////////////////////////////////////////////////

//Form reset
jQuery('#gma500-reset-update-product').click(function() {
	jQuery('#gma500-reset-update-product-form').submit();
});

//Product submit   
jQuery('#gma500-submit-update-product').click(function() {
	if (jQuery('#gma500-form-add-update-product').valid()) {
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
					"action": "gma500_admin_updateproduct",
					"id" : jQuery('#gma500-update-product-id').data('idproduct'),
					"idGMA" : jQuery('#idGMA').val(),
					"cathegory" : jQuery('#cathegory').val(),
					"brand" : jQuery('#marque').val(),
					"utilization" : jQuery('#utilization').val(),
					"serialNumber" : jQuery('#serialNumber').val(),
					"doc" : jQuery('#doc').val(),
					"isEPI" : jQuery('#epi').val(),
					"location" : jQuery('#location').val(),
					"description" : jQuery('#description').val(),	
					"image" : jQuery('#imagebase64').val(),
					"isRental" : jQuery('#isRental').val(),
					"bought" : jQuery('#bought').val(),																																									
				  },
			success: function(data) {
				console.log(data);
				var result = JSON.parse(data);
				if (result.error != null) {						
					jQuery('#gma500-add-product-ajax-result').html(result.error).removeClass('gma500-ajax-success').addClass('gma500-ajax-error').fadeIn();
				}
				if (result.success != null) {
					jQuery('#gma500-add-product-ajax-result').html(result.success).removeClass('gma500-ajax-error').addClass('gma500-ajax-success').fadeIn().delay(5000).fadeOut();
				}				
			}
		}).fail(function(err) {
			jQuery('#gma500-add-product-ajax-result').html("Une erreur est survenue").addClass('gma500-ajax-error');
		});		
	}
});



////////////////////////////////////////////////////////////////////////////////////
// MAIN
////////////////////////////////////////////////////////////////////////////////////
	//Search part
	jQuery('#admin-main-view-search-products').click(function() {
		console.log("searching");
		jQuery('#admin-main-view-products-list').html("");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
					"action": "gma500_searchproducts",
					"filter": jQuery('#admin-main-view-search-products-input').val()																																							
				  },
			success: function(data) {
				jQuery('#admin-main-view-products-list').html(data);
				//Redirect to product details admin with the id of the product selected
				jQuery('.gma500-product-admin-wrapper').click(function() {
					jQuery('#admin-main-view-product-detail-form-id').val(jQuery(this).data('idproduct'));
					jQuery('#admin-main-view-product-detail-form').submit();
				});
			}
		}).fail(function(err) {
			jQuery('#admin-main-view-products i').css("opacity", "0");
		});			
	});
///////////////////////////////
// PRODUCT DETAILS
//////////////////////////////
//Show correct assign/unassign
if (jQuery('#gma500-user-id').data('iduser')==0) {
	jQuery('#gma500-admin-product-details-unassign-more-button').hide();
} else {
	jQuery('#gma500-admin-product-details-assign-more-button').hide();
}

//Handle product delete
jQuery('#gma500-admin-product-details-delete-button').click(function() {
	if (confirm('Êtes vous sûr de vouloir supprimer ce matériel ?\nLe matériel avec ses controles et historic seront effaces de la base de donnes !')) {
		jQuery('#gma500-admin-product-details-delete-form').submit();
	};
})
jQuery('#gma500-admin-product-details-show-more-button').click(function () {
	if (jQuery('#gma500-admin-product-details-show-more-content').css('display') == "none")
		jQuery('#gma500-admin-product-details-show-more-content').slideDown();
	else
		jQuery('#gma500-admin-product-details-show-more-content').slideUp();
});


//Assign

jQuery('#gma500-admin-product-details-assign-more-button').click(function() {
	if (jQuery('#gma500-admin-product-details-assign-more-content').css('display') == "none")
		jQuery('#gma500-admin-product-details-assign-more-content').slideDown();
	else
		jQuery('#gma500-admin-product-details-assign-more-content').slideUp();
});


jQuery('#admin-main-product-details-search-user').click(function() {
	console.log("Searching users");
	jQuery('#admin-main-view-products-list').html("");
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: { 
				"action": "gma500_searchusers",
				"filter": jQuery('#admin-main-product-details-search-user-input').val()																																							
			  },
		success: function(data) {
			jQuery('#gma500-admin-product-details-users-list').html(data);
			jQuery('#gma500-assign-final-wrapper').css("display", "none");
			jQuery('.gma500-user-list-item').click(function() {
					jQuery('.gma500-user-list-item').removeClass('gma500-user-selected');
					jQuery(this).addClass('gma500-user-selected');
					jQuery('#gma500-assign-final-wrapper').css("display", "block");
			});
			jQuery('#gma500-assign-button').click(function() {
				//Assign finally to user
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: { 
							"action": "gma500_assign",
							"user_id": jQuery('.gma500-user-selected').data('iduser'),
							"product_id": jQuery('#gma500-product-id').data('idproduct'),
							"due":	jQuery('#gma500-assign-back-date').val()																																						
						  },
					success: function(data) {
						console.log(data);
						var result = JSON.parse(data);
						if (result.error != null) {						
							jQuery('#gma500-assign-ajax-result').html(result.error).hide().addClass('gma500-ajax-error').fadeIn();
						}
						if (result.success != null) {
							//Reload page
							jQuery('#gma500-reset-product-details-form').submit();
						}				
					}
				});

			});
		}
	});			

});
//Unassign part
jQuery('#gma500-admin-product-details-unassign-more-button').click(function() {
	if (jQuery('#gma500-admin-product-details-unassign-more-content').css('display') == "none")
		jQuery('#gma500-admin-product-details-unassign-more-content').slideDown();
	else
		jQuery('#gma500-admin-product-details-unassign-more-content').slideUp();
});
jQuery('#gma500-admin-product-details-unassign-button').click(function() {
	console.log("Unassign !!");
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: { 
				"action": "gma500_unassign",
				"product_id": jQuery('#gma500-product-id').data('idproduct'),
				"comment": jQuery('#gma500-unassign-comment').val()																																							
			  },
		success: function(data) {
			var result = JSON.parse(data);
			if (result.error != null) {						
				jQuery('#gma500-unassign-ajax-result').html(result.error).hide().addClass('gma500-ajax-error').fadeIn();
			} else {
				//Reload page
				jQuery('#gma500-reset-product-details-form').submit();
			}
		}});
});
//Historic part
jQuery('#gma500-admin-product-details-historic-more-button').click(function() {
	if (jQuery('#gma500-admin-product-details-historic-more-content').css('display') == "none")
		jQuery('#gma500-admin-product-details-historic-more-content').slideDown();
	else
		jQuery('#gma500-admin-product-details-historic-more-content').slideUp();
});


}); //End jQuery
