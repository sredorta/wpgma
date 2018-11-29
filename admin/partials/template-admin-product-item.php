<?php 
echo "<div class='gma500-product-admin-wrapper' data-idproduct=\"". $product->id ."\">";
echo "<div class='gma500-product-image-wrapper'><img  class='gma500-product-image-item' src=" . $product->image." alt='Image du matériel'></div>";
echo "<div class='gma500-product-admin-wrapper-data'>";

if ($product->user_id == 0) {
echo "<div class='gma500-product-available'><div class='gma500-usage-indicator gma500-product-not-in-use gma500-box-shadow'></div><div class='gma500-product-not-in-use-color'>Disponible</div></div>";
} else {
echo "<div class='gma500-product-available'><div class='gma500-usage-indicator gma500-product-in-use gma500-box-shadow'></div><div class='gma500-product-in-use-color'>Pas disponible</div></div>";
}
echo "<p class='gma500-product-admin-label'>IDGMA:</p>";
echo "<div class='gma500-product-admin-value gma500-product-admin-value-idgma'>" . $product->idGMA . "</div>";
echo "<p class='gma500-product-admin-label'>CATHEGORIE:</p>";
echo "<div class='gma500-product-admin-value'>" . $product->cathegory . "</div>";
echo "<p class='gma500-product-admin-label'>MARQUE:</p>";
echo "<div class='gma500-product-admin-value'>" . $product->brand . "</div>";
echo "</div>";
echo "</div>";