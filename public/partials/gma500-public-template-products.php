
<?php get_header();?>
<div class="wrap">
<h1 class='gma500-h1'>Liste de matériel en location</h1>
<div style='margin:0 auto'>
        <?php 
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE isRental = 1 ORDER BY cathegory;", $dummy);
        $products = $wpdb->get_results($sql);	
        
        if (sizeof($products)==0) {
            echo "<p>Pas de matériel disponible en location en ce moment</p>";
        } else {
            echo "
            <div class='gma500-products-list-wrapper gma500-products-list-main gma500-header' style='display:flex'>
                <div>IMAGE</div>
                <div>IDGMA</div>
                <div>CATHEGORIE</div>
                <div class='gma500-brand'>MARQUE</div>
                <div>DISPO</div>
            </div>";
        }?>

        <?php
        foreach ($products as $product) {
            echo "<div class='gma500-products-list-wrapper' data-idproduct=\"".$product->id."\">";
            echo "<div class='gma500-products-list-main' style='display:flex; width:100%'>";
                echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
                echo "<div class='gma500-id'>".$product->idGMA."</div>";
                echo "<div>".$product->cathegory."</div>";
                echo "<div class='gma500-brand'>".$product->brand."</div>";
                if ($product->user_id != 0) 
                    echo "<div style='color:red;font-weight:bold'>NON</div>";
                else
                    echo "<div style='color:green;font-weight:bold'>OUI</div>";    
            echo "</div>";
            echo "<div class='gma500-product-expansion'>";
            echo "<p class='gma500-product-label'>DESCRIPTION:</p>";
            echo "<p class='gma500-product-value'>" . stripcslashes($product->description) . "</p>";
            echo "<p class='gma500-product-label'>UTILIZATION:</p>";
            echo "<p class='gma500-product-value'>". $product->utilization . "</p>";
            if ($product->doc != "") {
                echo "<p class='gma500-product-label'>DOC:</p>";
            echo "<p class='gma500-product-value'><a href='". $product->doc . "'>Voir la documentation</a></p>";
            }         
            echo "</div>";
            echo "</div>";

        }
        ?>
        <div class='kubiiks-add'>
            <small>La géstion du matériel à éte fait par <a href='http://www.kubiiks.com'>kubiiks</a></small>
        </div>
</div>
</div>
<?php get_footer();?>