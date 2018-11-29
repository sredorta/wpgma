jQuery(document).ready(function() {
	console.log("ajaxurl is : " + ajaxurl);
	//Validation
	jQuery.validator.addMethod("valueNotEquals", function(value, element, arg){
		return arg !== value;
	   }, "Value must not equal arg.");
	  
	// configure your validation
	jQuery('#form-add-product').validate();
	/*{
		rules: {
		 SelectName: { valueNotEquals: "default" }
		},
		messages: {
		 SelectName: { valueNotEquals: "Sélectioner un element !" }
		}  
	});*/

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
	  //console.log(obj);
		//if (jQuery('#form-add-product').valid()) {
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
						jQuery('#gma500-add-product-ajax-result').html(result.error).addClass('gma500-ajax-success');
					}
				}
			}).done(function(data) {
				console.log("done !!!");
				console.log(data);
			}).fail(function(err) {
				console.log("error");
				console.log(err);
			})
			;
			return false;			
		//}
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
});
