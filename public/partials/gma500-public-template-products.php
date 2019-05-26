
<?php get_header();?>
<div class="gma500-wrap">
<div class="gma500-wrap-content">
<!--Include the post of the page in the top-->
<?php
    $thepageinquestion = get_post(get_the_ID());
    $content = $thepageinquestion->post_content;
    $content = apply_filters('the_content', $content);
    echo $content;
?>
</div>
    <!--SEARCH PRODUCT AJAX AND REDIRECTION-->
    <?php 
    if (current_user_can('Participant')) {
        echo "<div style='display:flex;vertical-align:center;max-width:400px;margin-left:25px;margin-bottom:15px'>";
        echo "<input id='public-search-products-input' type='text' name='search' id='search' placeholder='Chercher' value=''/>";
        echo "	<span class='input-group-btn'>";
        echo "		<button id='public-search-products' class='button button-secondary'><i class='fa fa-search fa-lg'></i></button>";
        echo "  </span>";
        echo "</div>";      
        echo "<div id ='public-main-view-products-list' style='margin:0 auto'>";
        global $wpdb;
        $table = $wpdb->prefix.'gma500_products';
        $sql = $wpdb->prepare ("SELECT * FROM ". $table . ' WHERE isRental = 1 ORDER BY cathegory,LENGTH(idGMA),idGMA;', $dummy);
        $products = $wpdb->get_results($sql);
        if (sizeof($products)==0 ) {
            echo "<p style='margin-left:20px;'>Pas de matériel disponible en ce moment</p>";
        } else {
                echo "
                <div class='gma500-product-item-main gma500-header' style='display:flex'>
                    <div>IMAGE</div>
                    <div>IDGMA</div>
                    <div>CATÉGORIE</div>
                    <div class='gma500-brand'>MARQUE</div>
                    <div>DISPO</div>
                </div>";
        }
        foreach ($products as $product) {
                echo "<div class='gma500-products-search-list-wrapper' data-idproduct=\"".$product->id."\">";
                    echo "<div class='gma500-product-item-main'>";
                    echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
                    echo "<div class='gma500-id'>".$product->idGMA."</div>";
                    echo "<div>".$product->cathegory."</div>";
                    echo "<div class='gma500-brand'>".$product->brand."</div>";
                    if ($product->user_id != 0) {
                        $meta = get_user_meta($product->user_id);
                        $name = $meta['first_name'][0] . " " . $meta['last_name'][0];
                        echo "<div><small style='color:red;font-weight:bold'>Utlizé par:</small><p style='word-wrap:break-word'>".$name."</p></div>";
                    } else
                        echo "<div style='color:green;font-weight:bold'>OUI</div>"; 
                    echo '</div>';       
                echo "<div class='gma500-product-expansion'>";
                echo "<p class='gma500-product-label'>DESCRIPTION:</p>";
                echo "<p class='gma500-product-value'>" . stripcslashes($product->description) . "</p>";
                if ($product->doc != "") {
                    echo "<p class='gma500-product-label'>DOC:</p>";
                echo "<p class='gma500-product-value'><a href='". $product->doc . "'>Voir la documentation</a></p>";
                }         
                echo "</div>";
                echo "</div>";
        }
    } else {
            echo "<h3 style='margin-left:40px'>Seulement les membres du club peuvent accéder au matériel</h3>";
            echo "<h4 style='margin-left:40px'>Si vous êtes membre du club, connectez-vous !</h4>";
    }     
    ?>
    </div>    
        <div class='kubiiks-add' style='margin:20px'>
            <small>Ce plugin de gestion du matériel à été fait par <a href='http://www.kubiiks.com'>kubiiks</a></small>
        </div>

</div>

<?php get_footer();?>