
    <!--Part that is not in the header but part of details-->
    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-show-more-button" class="button button-secondary">
            <i class="fa fa-plus-circle fa-lg"></i> Voir plus de détails
        </div>
        <div id="gma500-admin-product-details-show-more-content">
        <p class='gma500-product-admin-label'>NUMERO DE SERIE:</p>
        <?php echo "<p class='gma500-product-admin-value'>" . $product->serialNumber . "</p>";?>
        <p class='gma500-product-admin-label'>DISPOSITIF EPI:</p>
        <?php $isEPIText = "Non";
              if ($product->isEPI == 1) $isEPIText = "Oui";?>
        <?php echo "<p class='gma500-product-admin-value'>" . $isEPIText . "</p>";?>       
        <p class='gma500-product-admin-label'>TYPE D'UTILIZATION:</p>
        <?php echo "<p class='gma500-product-admin-value'>" . $product->utilization . "</p>";?>   
        <p class='gma500-product-admin-label'>LIEU DE STOCKAGE:</p>
        <?php echo "<p class='gma500-product-admin-value'>" . $product->location . "</p>";?>    
        <p class='gma500-product-admin-label'>DATE D'ACHAT:</p>
        <?php echo "<p class='gma500-product-admin-value'>" . $product->bought . "</p>";?>
        <p class='gma500-product-admin-label'>DISPONIBLE À LA LOCATION:</p>
        <?php $isRentalText = "Non";
              if ($product->isRental == 1) $isRentalText = "Oui";?>        
        <?php echo "<p class='gma500-product-admin-value'>" . $isRentalText . "</p>";?>   
        </div>                            
    </div>
    <!--Assign part-->
    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-assign-more-button" class="button button-secondary">
            <i class="fa fa-user-plus fa-lg"></i> Assigner
        </div>
        <div id="gma500-admin-product-details-assign-more-content">
            <div>
                <input id="admin-main-product-details-search-user-input" type="text" name="search" id="search" placeholder="Chercher" value=""/>
                <span class="input-group-btn">
                    <button id="admin-main-product-details-search-user" class="button button-secondary"><i class="fa fa-search fa-lg"></i>Chercher</button>
                </span>
            </div> 
            <div id="gma500-admin-product-details-users-list"></div>
        </div>        
    </div>    
   <!--Unassign part-->
   <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-unassign-more-button" class="button button-secondary">
            <i class="fa fa-user-times fa-lg"></i> Desassigner
        </div>
        <div id="gma500-admin-product-details-unassign-more-content">

        </div>
    </div>    


<div class="wrap">

    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-update-button" class="button button-primary" style="text-align:center">
        <i class="fa fa-edit"></i> Modifier
        </div>
        <form id="gma500-admin-product-details-update-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
            <input name="action" value="gma500_admin_updateproduct_page"/>
            <?php echo "<input name='id' value=" .$product_id.">";?>
        </form>   
        <div id="gma500-admin-product-details-delete-button" class="button button-primary"  style="text-align:center">
        <i class="fa fa-trash fa-lg"></i> Supprimer
        </div>
        <form id="gma500-admin-product-details-delete-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
            <input name="action" value="gma500_admin_deleteproduct_page"/>
            <?php echo "<input name='id' value=" .$product_id.">";?>
        </form>      
    </div> 
</div>