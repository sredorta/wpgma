jQuery(document).ready(function() {

///////////////////////////////////////////////////////////////////////////////////
// ADD PRODUCT
///////////////////////////////////////////////////////////////////////////////////
	// configure your validation
	jQuery('#form-add-product').validate();

	//Product submit   
	jQuery('#submit-add-product').click(function() {
		var obj = { "action": "addproduct",
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
		"bought" : jQuery('#bought').val(),																																									
	  };
		if (jQuery('#form-add-product').valid()) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
						"action": "gma500_addproduct",
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
						"bought" : jQuery('#bought').val(),																																									
					  },
				success: function(data) {
					var result = JSON.parse(data);
					if (result.error != null) {						
						jQuery('#gma500-add-product-ajax-result').html(result.error).addClass('gma500-ajax-error');
					}
					if (result.success != null) {
						jQuery('#gma500-add-product-ajax-result').html(result.success).addClass('gma500-ajax-success');
					}
				}
			}).fail(function(err) {
				jQuery('#gma500-add-product-ajax-result').html("Une erreur est survenue").addClass('gma500-ajax-error');
			});		
		}
	});
	//Reset form   
	jQuery('#reset-add-product').click(function() {
		window.location.reload();
	});


	//Handle image with base64
	// imagebase64 is a hidden input that contains the value that will be send for storing
	//		it can be the default or the base64 string after processing
	jQuery('#imagebase64').val("../wp-content/plugins/gma500/admin/assets/default-product.jpg");
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
////////////////////////////////////////////////////////////////////////////////////
// MAIN
////////////////////////////////////////////////////////////////////////////////////
/*	jQuery('#admin-main-view-products').click(function() {
		jQuery('#admin-main-view-products i').css("opacity", "1");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
					"action": "gma500_getproducts"																																								
				  },
			success: function(data) {
				jQuery('#admin-main-view-products-list').html(data);
				jQuery('#admin-main-view-products i').css("opacity", "0");
			}
		}).fail(function(err) {
			jQuery('#admin-main-view-products i').css("opacity", "0");
		});		

	});*/
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
					//Redirect to product details admin
				jQuery('.gma500-product-admin-wrapper').click(function() {
					console.log("Going to product detail: " + jQuery(this).data('idproduct'));
				});
			}
		}).fail(function(err) {
			jQuery('#admin-main-view-products i').css("opacity", "0");
		});			
	});



}); //End jQuery
