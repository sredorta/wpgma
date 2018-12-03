
<div class="wrap">
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
        <?php 
            echo "<p class='gma500-product-admin-value'>" . explode(" ",$product->bought)[0] . "</p>";
            ?>
        <p class='gma500-product-admin-label'>DISPONIBLE À LA LOCATION:</p>
        <?php $isRentalText = "Non";
              if ($product->isRental == 1) $isRentalText = "Oui";?>        
        <?php echo "<p class='gma500-product-admin-value'>" . $isRentalText . "</p>";?>   
        </div>                            
    </div>
    <!--Historic show-->
    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-historic-more-button" class="button button-secondary">
            <i class="fa fa-history fa-lg"></i> Historic
        </div>
        <div id="gma500-admin-product-details-historic-more-content">
            <?php if (sizeof($historics) == 0) {
                echo "<div>Pas d'historic de location pour le moment</div>";
            } else {
                echo "<div class='gma500-historic-item gma500-header'>
                        <div class='gma500-historic-wrapper'>
                            <div class='gma500-historic-item-name'>NOM</div>
                            <div class='gma500-historic-item-email'>EMAIL</div>
                            <div class='gma500-historic-item-start'>EMPRUNTÉ:</div>
                            <div class='gma500-historic-item-start'>RÉTOUR:</div>
                        </div>
                    </div>";            
             foreach($historics as $historic) {
                $start = explode (" ", $historic->start)[0];
                $end = explode(" ",$historic->end)[0];

                    echo "<div class='gma500-historic-item'>";
                    echo "<div class='gma500-historic-wrapper'>";
                    echo "<div class='gma500-historic-item-name'>".$historic->first_name." ". $historic->last_name."</div>";
                    echo "<div class='gma500-historic-item-email'>".$historic->email."</div>";
                    echo "<div class='gma500-historic-item-start'>".$start."</div>";
                    echo "<div class='gma500-historic-item-end'>".$end."</div>";
                    echo "</div>";
                    echo "<p class='gma500-product-admin-label'>COMMENTAIRE:</p>";
                    echo "<div class='gma500-historic-item-comment'>".$historic->comment."</div>";
                    echo "</div>";
                }
            }?>
        </div>
    </div>  



    <!--Assign part-->
    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-assign-more-button" class="button button-secondary">
            <i class="fa fa-user-plus fa-lg"></i> Assigner
        </div>
        <div id="gma500-admin-product-details-assign-more-content">
            <div>
                <input id="admin-main-product-details-search-user-input" type="text" name="search" id="search" placeholder="Chercher membre" value=""/>
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
          <p style='width:100%'>COMMENTAIRE:<br /><textarea class='gma500-textarea' id='gma500-unassign-comment' name='comment' type='text' maxlength='400'></textarea></p>
          <div id='gma500-unassign-ajax-result'></div>
          <div id="gma500-admin-product-details-unassign-button" class="button button-primary">Desassigner</div>          
        </div>
    </div>    

    <!--Controls-->
    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-controls-more-button" class="button button-secondary">
            <i class="fa fa-flag fa-lg"></i> Controles
        </div>
        <div id="gma500-admin-product-details-controls-more-content">
        <div id="gma500-admin-product-details-controls-add-button" class="button button-secondary"><i class="fa fa-plus-circle fa-lg"></i> Créer un nouveau controle</div> 
            <div id="gma500-admin-product-details-controls-add-form-wrapper">
                <form id="gma500-admin-product-details-controls-add-form" method="post">
                    <div style="display:flex;flex-flow:row">
                        <div style="min-width:300px;width:100%">
                            <p>TYPE*:<br />
                                <select id="gma500-controls-add-type" name="type" required style="width:170px">
                                    <option value=''>--Sélectioner--</option>               
                                    <option value="Rebut">Rebut</option>
                                    <option value="Périodique">Périodique</option>
                                </select>  
                            </p>                        
                            <?php echo "<p>DÉSCRIPTION*:<br /><textarea class='gma500-textarea' id='gma500-controls-add-description' name='description' type='text' maxlength='400' required minlength='5'></textarea></p>"?>
                            <?php echo "<p>À CONTROLER LE*:<br /><input  id='gma500-controls-add-due' name='due' type='date' required minlength='3' style='width:170px' value=''></p>"?>
                        </div>  
                    </div>                        
                </form>
                <div id='gma500-controls-add-ajax-result'></div>
                <div id="gma500-admin-product-details-controls-add-button-submit" class="button button-primary" style="margin-bottom:10px"><i class="fa fa-plus-circle fa-lg"></i> Ajouter le controle</div> 
            </div>
            <?php if (sizeof($controls) == 0) {
                    echo "<p>Pas de controles sur ce matériel</p>";
                } else {
                    
                    echo "
                        <div class='gma500-controls-item gma500-header'>
                            <div class='gma500-controls-wrapper'>
                                <div class='gma500-controls-item-type'>TYPE</div>
                                <div class='gma500-controls-item-created'>CRÉATION</div>
                                <div class='gma500-controls-item-due'>LIMITE</div>
                                <div class='gma500-controls-item-status'>STATUS</div>
                            </div>
                        </div>";

                    foreach($controls as $control) {
                        $created = explode (" ", $control->created)[0];
                        $due = explode(" ",$control->due)[0];

                        echo "<div class='gma500-controls-item'>";
                        echo "<div class='gma500-controls-wrapper'>";
                        echo "<div class='gma500-controls-item-type'>".$control->type."</div>";
                        echo "<div class='gma500-controls-item-created'>".$created."</div>";
                        echo "<div class='gma500-controls-item-due'>".$due."</div>";
                        if ($control->status == "ouvert")
                            echo "<div class='gma500-controls-item-status' style='color:orange;font-weight:bold'>". $control->status."</div>";
                        else
                            echo "<div class='gma500-controls-item-status' style='color:green;font-weight:bold'>". $control->status."</div>";

                        //echo "<div class='gma500-controls-item-end'>".$end."</div>";
                        echo "</div>";
                        echo "<p class='gma500-product-admin-label'>DÉSCRIPTION:</p>";
                        echo "<div class='gma500-controls-item-comment'>".$control->description."</div>";
                        if ($control->status == "ouvert")
                            echo "<div style='width:100%;display:flex;justify-content:flex-end'><div style='margin:5px' class='button button-primary gma500-controls-item-close' data-idcontrol=\"".$control->id."\"><i class='fa fa-check-circle fa-lg'></i> Fermer</div></div>";
                        echo "</div>";
                    }
                }?>
        </div>
    </div>  



    <div  style="display:flex;flex-flow:column;max-width:600px;margin:0 auto;margin-top:5px">
        <div id="gma500-admin-product-details-update-button" class="button button-primary" style="text-align:center">
        <i class="fa fa-edit"></i> Modifier
        </div>
        <form id="gma500-admin-product-details-update-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
            <input name="action" value="gma500_admin_updateproduct_page"/>
            <?php echo "<input name='id' value=" .$product_id.">";?>
        </form>   
        <div id="gma500-admin-product-details-delete-button" class="button button-primary"  style="text-align:center;margin-top:5px;">
        <i class="fa fa-trash fa-lg"></i> Supprimer
        </div>
        <form id="gma500-admin-product-details-delete-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
            <input name="action" value="gma500_admin_deleteproduct_page"/>
            <?php echo "<input name='id' value=" .$product_id.">";?>
        </form>      
        <div id="gma500-admin-product-details-back-to-main" class="button button-secondary"  style="text-align:center;margin-top:20px;">
        <i class='fa fa-chevron-left fa-lg'></i> Retour à la page principale
        </div>        
        <form id='gma500-back-to-main-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
		</form>

    </div> 
</div>