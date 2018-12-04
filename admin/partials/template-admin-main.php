<div class="wrap">
    <div>
        <img class="gma500-banner-image" src="../wp-content/plugins/gma500/admin/assets/banner.jpg" alt="Géstion du matériel du club"/>
    </div>    
    <h1 class="gma500-h1" style="margin-bottom:10px;">Géstion du matériel du club</h1>

    <!--ADD PRODUCT REDIRECTION-->
    <div id="gma500-admin-main-submit-add-product-page-button" class="button button-primary">
            <i class="fa fa-plus-circle fa-lg"></i> Ajouter du matos
    </div>
    <form id="gma500-admin-main-submit-add-product-page-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
        <input name="action" value="gma500_admin_addproduct_page"/>
    </form>    

    <!--LIST PRODUCTS IN USE-->
    <h2>Liste de matériel en utilization</h2>
    <?php if (sizeof($products)==0) {
            echo "<p>Pas de matériel en utilization en ce moment</p>";
        } else {
            echo "
            <div class='gma500-products-in-use-list-wrapper gma500-header' style='display:flex'>
                <div>IMAGE</div>
                <div>IDGMA</div>
                <div>CATHEGORIE</div>
                <div>MARQUE</div>
                <div>IL RESTE:</div>
            </div>";
        }?>

        <?php
        foreach ($products as $product) {


            foreach ($historics_last as $historic) {
                if ($historic->product_id == $product->id) $duedate = $historic->end;
            }
            $date = DateTime::createFromFormat('Y-m-d', explode(" ",$duedate)[0]);
            $due = $date->format('U'); 
            $now = new DateTime();
            $now = $now->format('U');
            $diff = $due - $now;
            $diff = round($diff / (3600 * 24)); //Convert to days

            echo "<div class='gma500-products-in-use-list-wrapper' data-idproduct=\"".$product->id."\" style='display:flex'>";
            echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$product->image. "\" alt='Image du matériel'></div>";
            echo "<div>".$product->idGMA."</div>";
            echo "<div>".$product->cathegory."</div>";
            echo "<div>".$product->brand."</div>";
            if ($diff<0) 
                echo "<div style='color:red;font-weight:bold'>Dépasé de ".abs($diff)." jours </div>";
            else
                echo "<div style='color:green;font-weight:bold'>".$diff." jours </div>";    
            echo "</div>";
        }
        ?>

    <!--SEARCH PRODUCT AJAX AND REDIRECTION-->
    <h2>Chercher du matériel</h2>
    <div>
        <input id="admin-main-view-search-products-input" type="text" name="search" id="search" placeholder="Chercher" value=""/>
		<span class="input-group-btn">
			<button id="admin-main-view-search-products" class="button button-secondary"><i class="fa fa-search fa-lg"></i>Chercher</button>
        </span>
    </div>      
    <div id ="admin-main-view-products-list"></div>
    <form id="admin-main-view-product-detail-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post"> 
            <input name="action" value="gma500_admin_viewproductdetails"/>
            <input id="admin-main-view-product-detail-form-id" name="id" value="1"/>
    </form>


    <!--CONTROLS THAT HAVE TO BE DONE-->
    <h2>Controls à faire</h2>
    <?php if (sizeof($controls)== 0) {
        echo "<p>Pas de controls à venir dans les prochains 30 jours</p>";
    } else {
        echo "<div class='gma500-controls-hot-list-wrapper gma500-header' style='display:flex'>
                <div>IMAGE</div>
                <div>IDGMA</div>
                <div>DATE</div>
                <div>IL RESTE:</div>
            </div>";
    }?>
    <?php
    foreach ($controls as $control) {
        foreach($products_all as $product) {
            if ($control->product_id == $product->id) $myproduct = $product;
        }
        $date = DateTime::createFromFormat('Y-m-d', explode(" ",$control->due)[0]);
        $due = $date->format('U'); 
        $now = new DateTime();
        $now = $now->format('U');
        $diff = $due - $now;
        $diff = round($diff / (3600 * 24)); //Convert to days
        //Show hot controls from 30 days before
        if ($diff < 30) {
            echo "<div class='gma500-controls-hot-list-wrapper' data-idproduct=\"".$myproduct->id."\" style='display:flex'>";
            echo "<div><img class='gma500-product-image gma500-image-small' src=\"" .$myproduct->image. "\" alt='Image du matériel'></div>";
            echo "<div>".$myproduct->idGMA."</div>";
            echo "<div>".explode(" ",$control->due)[0]."</div>";
            if ($diff < 10) 
                if ($diff<0)
                    echo "<div style='color:red;font-weight:bold'>Dépasé de ".abs($diff)." jours </div>";
                else
                    echo "<div style='color:red;font-weight:bold'>". $diff ." jours</div>";
            else
                echo "<div style='color:orange;font-weight:bold'>". $diff ." jours</div>";
            echo "</div>";
        }
    }
    ?>


</div>    