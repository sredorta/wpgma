<?php echo "Product details : " .$product_id;?>
<div class="wrap">
    <div id="gma500-admin-product-details-update-button" class="button button-primary">
    <i class="fa fa-plus-circle fa-lg"></i> Modifier
    </div>
    <form id="gma500-admin-product-details-update-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
        <input name="action" value="gma500_admin_updateproduct_page"/>
        <?php echo "<input name='id' value=" .$product_id.">";?>
    </form>   
    <div id="gma500-admin-product-details-delete-button" class="button button-primary">
    <i class="fa fa-trash fa-lg"></i> Supprimer
    </div>
    <form id="gma500-admin-product-details-delete-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
        <input name="action" value="gma500_admin_deleteproduct_page"/>
        <?php echo "<input name='id' value=" .$product_id.">";?>
    </form>       
</div>