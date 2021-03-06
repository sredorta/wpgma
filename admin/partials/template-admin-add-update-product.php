<div class="wrap wrap-no-padding">
    <div>
        <img class="gma500-banner-image" src="../wp-content/plugins/gma500/admin/assets/banner.jpg" alt="Géstion du matériel du club"/>
    </div>    
    <?php if ($idGMA!="") echo "<h1 class='gma500-h1'>Modifier le matériel</h1>";
          else echo "<h1 class='gma500-h1'>Ajouter du matériel</h1>";?>
    <form id="gma500-form-add-update-product"  method="post"> 
      <div style="display:flex;flex-flow:row wrap-reverse;max-width:400px;margin:0 auto">
        <div style="min-width:200px;margin:0 auto">
            <?php echo "<p>ID GMA*:<br /><input  id='idGMA' name='idGMA' type='text' required minlength='3' style='width:170px' value='".$idGMA."'></p>"?>
            <?php echo "<p>MARQUE*:<br /><input  id='marque' name='brand' type='text' required minlength='3' style='width:170px' value='".$brand."'></p>"?>
            <?php echo "<p>NUMÉRO DE SÉRIE:<br /><input  id='serialNumber' name='serialNumber' type='text' style='width:170px' value='".$serialNumber."'></p>"?>
        </div>  
        <div style="min-width:200px;display:flex;flex-flow:column;justify-content:center;margin:0 auto">
            <div style="display:flex;justify-content:center">
                
                <?php if ($image=="") $image = "../wp-content/plugins/gma500/admin/assets/default-product.jpg";
                      echo "<img id='productImage' class='gma500-product-image' src=" .$image. " alt='Image du matériel'>"?>
                <img class="gma500-shadow" alt="shadow" id="shadowImg" style="display:none">
                <canvas class="gma500-shadow" id="shadowCanvas"></canvas>
                <input  class="gma500-shadow" type="file" id="fileInput">  
                <input  class="gma500-shadow" type="text" id="imagebase64" name="image">
            </div>
            <div style="display:flex;flex-flow:row;justify-content:center">
                <div id="upload" class="button button-secondary">
                    <i class="fa fa-camera fa-lg"></i>
                </div>            
                <div id="clear" class="button button-secondary">
                    <i class="fa fa-trash fa-lg"></i>
                </div> 
                <div id="rotate" class="button button-secondary">
                    <i class="fa fa-undo fa-lg fa-flip-vertical"></i>
                </div>                                 
            </div>
        </div> 
      </div>     
      <div style="display:flex;flex-flow:row wrap;max-width:400px;margin:0 auto">
        <div style="min-width:200px;margin:0 auto">
            <p>CATÉGORIE*:<br />
            <select id='cathegory' name='cathegory' required style='width:170px'>
            <?php if ($cathegory!="") echo "<option value=". $cathegory. " selected='selected'>".$cathegory."</option>";
                  else echo "<option value=''>--Sélectioner--</option>";
                  foreach ($cathegories as $tmp) {
                      echo "<option value='".$tmp->meta_value."'>".$tmp->meta_value."</option>";
                  }?>
            </select>           
            </p>
            <p>EPI*:<br />
            <select id="epi" name="isEPI" required style="width:170px">
            <?php $epiText = "Oui";
                  if ($isEPI == "0") $epiText = "Non";
                  if ($isEPI!="") echo "<option value=". $isEPI. " selected='selected'>".$epiText."</option>";
                  else echo "<option value=''>--Sélectioner--</option>";?>               
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>  
            </p>   
            <p>LIEU*:<br />
            <select id="location" name="location" required style="width:170px">
            <?php if ($location!="") echo "<option value='". $location. "' selected='selected'>".$location."</option>";
                  else echo "<option value=''>--Sélectioner--</option>";
                  foreach ($locations as $tmp) {
                    echo "<option value='".$tmp->meta_value."'>".$tmp->meta_value."</option>";
                  }?>                              
            </select>              
            </p>

        </div>  
        <div style="min-width:200px;margin:0 auto">

            <?php echo "<p>DOC:<br /><input  id='doc' name='doc' type='url' optional style='width:170px' value=". $doc."></p>"?>
            <?php echo "<p>DATE ACHAT*:<br /><input  id='bought' name='bought' type='date' required style='width:170px' value=".$bought."></p>"?>
        </div>         
      </div> 
      <div style="display:flex;flex-flow:column;max-width:400px;min-width:200px;margin:0 auto">
        <p>Disponilbe au prêt*:<br />
            <select id="isRental" name="isRental" required style="width:170px">
            <?php $isRentalText = "Oui";
                  if ($isRental == "0") $isRentalText = "Non";
                  if ($isRental!="") echo "<option value=". $isRental. " selected='selected'>".$isRentalText."</option>";
                  else echo "<option value=''>--Sélectioner--</option>";?>            
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>              
        </p>        
        <?php echo "<p style='width:100%'>DESCRIPTION*:<br /><textarea class='gma500-textarea' id='description' name='description' type='text' required minlength='3' maxlength='400'>".$description."</textarea></p>"?>
        <div id="gma500-add-product-ajax-result" class="gma500-ajax"></div>    
      </div>    
    </form>

</div>