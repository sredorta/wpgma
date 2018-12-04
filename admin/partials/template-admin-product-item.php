
<?php        
    echo "<div class='gma500-products-search-list-wrapper' data-idproduct=\"".$product->id."\" style='display:flex'>";
    echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
    echo "<div>".$product->idGMA."</div>";
    echo "<div>".$product->cathegory."</div>";
    echo "<div>".$product->brand."</div>";
    if ($product->user_id == 0)
        echo "<div style='font-weight:bold;color:green'>OUI</div>";
    else
        echo "<div style='font-weight:bold;color:red'>NON</div>";
    echo "</div>";
?>
