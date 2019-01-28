jQuery(document).ready(function() {
	console.log("We loaded the js !!!!");
	jQuery('.gma500-products-search-list-wrapper').click(function() {
		jQuery(this).find('.gma500-product-expansion').slideToggle();
	});

	jQuery('#public-search-products').click(function() {
		console.log("searching");
		jQuery('#public-main-view-products-list').html("");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
					"action": "gma500_searchproducts",
					"filter": jQuery('#public-search-products-input').val()																																							
				  },
			success: function(data) {
				console.log("Result is");
				console.log(data);
				jQuery('#public-main-view-products-list').html("<p>Resultats pour '"+jQuery('#public-search-products-input').val()+"' :</p>" + data);
			}
		}).fail(function(err) {
			console.log(err);
			jQuery('#admin-main-view-products i').css("opacity", "0");
		});			
	});
});
