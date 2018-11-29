<?php 
echo "<div class='gma500-product-admin-wrapper' data-idproduct=\"". $product->id ."\">";
if ($product->user_id != 0) {
    echo "<div class='gma500-product-image-wrapper'><div class='gma500-usage-indicator gma500-product-in-use'></div><img  class='gma500-product-image-item' src=" . $product->image." alt='Image du matériel'></div>";
} else {
    echo "<div class='gma500-product-image-wrapper'><div class='gma500-usage-indicator gma500-product-not-in-use'></div><img  class='gma500-product-image-item' src=" . $product->image." alt='Image du matériel'></div>";
}
echo "<div class='gma500-product-admin-wrapper-data'>";
echo "<p class='gma500-product-admin-label'>IDGMA:</p>";
echo "<div class='gma500-product-admin-value gma500-product-admin-value-idgma'>" . $product->idGMA . "</div>";
echo "<p class='gma500-product-admin-label'>CATHEGORIE:</p>";
echo "<div class='gma500-product-admin-value'>" . $product->cathegory . "</div>";
echo "<p class='gma500-product-admin-label'>MARQUE:</p>";
echo "<div class='gma500-product-admin-value'>" . $product->brand . "</div>";
echo "</div>";
echo "</div>";