
<?php get_header();?>
<div class="wrap">

<!--Include the post of the page in the top-->
<?php
    $thepageinquestion = get_post(get_the_ID());
    $content = $thepageinquestion->post_content;
    $content = apply_filters('the_content', $content);
    echo $content;
?>

    <!--SEARCH PRODUCT AJAX AND REDIRECTION-->
    <div style='display:flex;vertical-align:center;max-width:400px;margin-left:5px;margin-bottom:15px'>
        <input id="public-search-products-input" type="text" name="search" id="search" placeholder="Chercher" value=""/>
		<span class="input-group-btn">
			<button id="public-search-products" class="button button-secondary"><i class="fa fa-search fa-lg"></i></button>
        </span>
    </div>      
    <div id ="public-main-view-products-list" style='margin:0 auto'>
        <?php 
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE isRental = 1 ORDER BY cathegory;", $dummy);
        $products = $wpdb->get_results($sql);
        
        if (sizeof($products)==0) {
            echo "<p>Pas de matériel disponible en ce moment</p>";
        } else {
            echo "
            <div class='gma500-product-item-main gma500-header' style='display:flex'>
                <div>IMAGE</div>
                <div>IDGMA</div>
                <div>CATÉGORIE</div>
                <div class='gma500-brand'>MARQUE</div>
                <div>DISPO</div>
            </div>";
        }?>

        <?php
        foreach ($products as $product) {
            echo "<div class='gma500-products-search-list-wrapper' data-idproduct=\"".$product->id."\">";
                echo "<div class='gma500-product-item-main'>";
                echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
                echo "<div class='gma500-id'>".$product->idGMA."</div>";
                echo "<div>".$product->cathegory."</div>";
                echo "<div class='gma500-brand'>".$product->brand."</div>";
                if ($product->user_id != 0) 
                    echo "<div style='color:red;font-weight:bold'>NON</div>";
                else
                    echo "<div style='color:green;font-weight:bold'>OUI</div>"; 
                echo '</div>';       
            echo "<div class='gma500-product-expansion'>";
            echo "<p class='gma500-product-label'>DESCRIPTION:</p>";
            echo "<p class='gma500-product-value'>" . stripcslashes($product->description) . "</p>";
            echo "<p class='gma500-product-label'>UTILISATION:</p>";
            echo "<p class='gma500-product-value'>". $product->utilization . "</p>";
            if ($product->doc != "") {
                echo "<p class='gma500-product-label'>DOC:</p>";
            echo "<p class='gma500-product-value'><a href='". $product->doc . "'>Voir la documentation</a></p>";
            }         
            echo "</div>";
            echo "</div>";

        }
        ?>
    </div>    
        <div class='kubiiks-add' style='margin:0 auto'>
            <small>Ce plugin de gestion du matériel à été fait par <a href='http://www.kubiiks.com'>kubiiks</a></small>
        </div>

</div>

<?php get_footer();?>