<div class="wrap">
    <div>
        <img class="gma500-banner-image" src="../wp-content/plugins/gma500/admin/assets/banner.jpg" alt="Géstion du matériel du club"/>
    </div>    
    <form id="gma500-reset-config-page" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
            <input name="action" value="gma500_admin_config"/>
    </form>    
    <form id="gma500-config-back-to-home" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
    </form>   
    <h1 class="gma500-h1" style="margin-bottom:10px;">Configuration</h1>

    <h3>Catégories de matériel</h3>
    <?php foreach($cathegories as $cathegory) {
        echo "<div style='display:flex;justify-content:center;width:300px' class='gma500-config-item'>";
        echo "<div style='flex:1'><p>".$cathegory->meta_value."</p></div>";
        echo "<div style='flex:1;' data-idconfig=\"".$cathegory->id."\" class='gma500-config-remove-button'><p><i class='fa fa-trash fa-lg'></i> Supprimer</p></div>";
        echo "</div>";
    }?>
    <div style='display:flex;vertical-align:center;'>
        <div>
            <form id='gma500-config-add-cathegory-form' class='gma500-config-add-form' style="margin:10px;margin-right:0px;">
             <input type='text' optional style='width:170px' value="" required minlength='3'>
            </form>
        </div>   
        <div style='display:flex;flex-flow:column;justify-content:center'>     
        <div id="gma500-admin-main-submit-add-cathegory-button" class="button button-primary">
                <i class="fa fa-plus-circle fa-lg"></i> Ajouter
        </div>
        </div>
    </div>

    <h3>Lieu de stockage du matériel</h3>
    <?php foreach($locations as $cathegory) {
        echo "<div style='display:flex;justify-content:center;width:300px' class='gma500-config-item'>";
        echo "<div style='flex:1'><p>".$cathegory->meta_value."</p></div>";
        echo "<div style='flex:1;' data-idconfig=\"".$cathegory->id."\" class='gma500-config-remove-button'><p><i class='fa fa-trash fa-lg'></i> Supprimer</p></div>";
        echo "</div>";
    }?>
    <div style='display:flex;vertical-align:center;'>
        <div>
            <form id='gma500-config-add-location-form' class='gma500-config-add-form' style="margin:10px;margin-right:0px;">
             <input type='text' optional style='width:170px' value="" required minlength='3'>
            </form>
        </div>   
        <div style='display:flex;flex-flow:column;justify-content:center'>     
        <div id="gma500-admin-main-submit-add-location-button" class="button button-primary">
                <i class="fa fa-plus-circle fa-lg"></i> Ajouter
        </div>
        </div>
    </div>
    <div id="gma500-config-back-button" class="button button-secondary">
                <i class="fa fa-chevron-left fa-lg"></i> Retour à la page principale
        </div>

</div>
