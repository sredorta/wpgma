<div class="wrap" style="width:100%">
    <?php echo "<div id='gma500-product-id' data-idproduct=\"". $product->id."\"></div>";?>
    <?php echo "<div id='gma500-user-id' data-iduser=\"". $product->user_id."\"></div>";?>
    <form id='gma500-reset-product-details-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
        <input name='action' value='gma500_admin_viewproductdetails'/>
        <?php echo "<input name='id' value='".$product->id."'>";?>
	</form>
    <div style="display:flex;flex-flow:row wrap;max-width:600px;margin:0 auto">
       <div style="max-width:300px;display:flex;flex-flow:column;justify-content:center">
       <?php if ($product->image=="") $product->image = "../wp-content/plugins/gma500/admin/assets/default-product.jpg";
             echo "<div style='margin:0 auto'><img class='gma500-product-image' src=" .$product->image. " alt='Image du matériel'></div>";
             if ($product->user_id == 0) {
                echo "<div class='gma500-product-available' style='margin:0 auto'><div class='gma500-usage-indicator gma500-product-not-in-use gma500-box-shadow'></div><div class='gma500-product-not-in-use-color'>Disponible</div></div>";
                } else {
                echo "<div class='gma500-product-available' style='margin:0 auto'><div class='gma500-usage-indicator gma500-product-in-use gma500-box-shadow'></div><div class='gma500-product-in-use-color'>Pas disponible</div></div>";
                }             
             ?>
        </div>     
       <div style="max-width:300px">
            <p class='gma500-product-admin-label'>IDGMA:</p>
            <?php echo "<p class='gma500-product-admin-value'>". $product->idGMA . "</p>"?>
            <p class='gma500-product-admin-label'>CATHEGORIE:</p>
            <?php echo "<p class='gma500-product-admin-value'>" . $product->cathegory . "</p>"?>
            <p class='gma500-product-admin-label'>MARQUE:</p>
            <?php echo "<p class='gma500-product-admin-value'>" . $product->brand . "</p>"?>                       
        </div>
    </div>
    <div style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:20px">
        <?php if ($user->user_email != null) {
                echo "<p class='gma500-product-admin-label'>UTILIZÉ PAR:</p>";
                echo "<div style='display:flex;width:100%;padding:5px' class='gma500-user-wrapper'>";
                echo "<div>";
                if ($user->avatar != null)
                    echo "<img src=".$user->avatar." alt_text='avatar' style='width:50px;height:50px'>";
                echo "</div>";    
                echo "<div style='margin-left:20px'>";
                echo "<p class='gma500-product-admin-value' style='margin-bottom:2px;font-weight:bold'>" .$user->first_name." ". $user->last_name ."</p>";
                echo "<p class='gma500-product-admin-value'>" .$user->user_email."</p>";
                echo "</div>";
                echo "</div>";
              }?>
        <p class='gma500-product-admin-label'>DESCRIPTION:</p>
        <?php echo "<p class='gma500-product-admin-value'>" . $product->description . "</p>";?>
        <?php if ($product->doc != "") {
            echo "<p class='gma500-product-admin-label'>DOC:</p>";
            echo "<p class='gma500-product-admin-value'><a href='". $product->doc . "'>Voir la documentation</a></p>";
        }?>
    </div>
<div>    