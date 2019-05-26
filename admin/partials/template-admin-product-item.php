
<?php        
    echo "<div class='gma500-products-search-list-wrapper' data-idproduct=\"".$product->id."\">";
    echo "<div class='gma500-product-item-main'>";
    echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
    echo "<div>".$product->idGMA."</div>";
    echo "<div>".stripcslashes($product->cathegory)."</div>";
    echo "<div>".stripcslashes($product->brand)."</div>";
    if ($product->user_id != 0) {
        $meta = get_user_meta($product->user_id);
        $name = $meta['first_name'][0] . " " . $meta['last_name'][0];
        echo "<div><small style='color:red;font-weight:bold'>Utlizé par:</small><p style='word-wrap:break-word'>".$name."</p></div>";
    } else {
        echo "<div style='color:green;font-weight:bold'>OUI</div>"; 
    }
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
?>
