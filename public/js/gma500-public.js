jQuery(document).ready(function() {
	console.log("We loaded the js !!!!");
	jQuery('.gma500-products-list-wrapper').click(function() {
		jQuery(this).find('.gma500-product-expansion').slideToggle();
	});
});
