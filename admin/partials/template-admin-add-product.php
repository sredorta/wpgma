<div class="wrap wrap-no-padding">
    <div>
        <img class="gma500-banner-image" src="../wp-content/plugins/gma500/admin/assets/banner.jpg" alt="Géstion du matériel du club"/>
    </div>    
    <h1 class="gma500-h1">Ajouter du materiel</h1>
    <form id="form-add-product" action="?action=addproduct" method="post"> 
      <div style="display:flex;flex-flow:row wrap-reverse;max-width:400px;margin:0 auto">
        <div style="min-width:200px;margin:0 auto">
            <p>ID GMA*:<br /><input  id="idGMA" name="idGMA" type="text" required minlength="3" style="width:170px"/></p>
            <p>MARQUE*:<br /><input  id="marque" name="brand" type="text" required minlength="3" style="width:170px"/></p>
            <p>NÚMERO DE SÉRIE*:<br /><input  id="serialNumber" name="serialNumber" type="text" required minlength="3" style="width:170px"/></p>
        </div>  
        <div style="min-width:200px;display:flex;flex-flow:column;justify-content:center;margin:0 auto">
            <div style="display:flex;justify-content:center">
                <img id="productImage" class="gma500-product-image" src="../wp-content/plugins/gma500/admin/assets/default-product.jpg" alt="Image du matériel">
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
            <p>CATHEGORIE*:<br />
            <select id="cathegory" name="cathegory" required style="width:170px">
                <option value="">--Sélectioner--</option>
                <option value="Corde">Corde</option>
                <option value="Arva">Arva</option>
                <option value="Chaussures">Chaussures</option>
                <option value="Skis">Skis</option>
                <option value="Degaines">Degaines</option>
                <option value="Livre">Livre</option>
            </select>            
            </p>
            <p>UTILIZATION*:<br />
            <select id="utilization" name="utilization" required style="width:170px">
                <option value="">--Sélectioner--</option>
                <option value="Salle">Salle</option>
                <option value="Exterieur">Exterieur</option>
            </select>  
            </p>
            <p>EPI*:<br />
            <select id="epi" name="isEPI" required style="width:170px">
                <option value="">--Sélectioner--</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>  
            </p>            
        </div>  
        <div style="min-width:200px;margin:0 auto">
            <p>INDROIT*:<br />
            <select id="location" required style="width:170px">
                <option value="">--Sélectioner--</option>
                <option value="Amiral">Amiral</option>
                <option value="Local">Local</option>
            </select>              
            </p>
            <p>DOC:<br /><input  id="doc" name="doc" type="url" optional style="width:170px"/></p>
            <p>DATE ACHAT*:<br /><input  id="bought" name="bought" type="date" required style="width:170px"/></p>
        </div>         
      </div> 
      <div style="display:flex;flex-flow:column;max-width:400px;min-width:200px;margin:0 auto">
        <p style="width:100%">DESCRIPTION*:<br /><textarea class="gma500-textarea" id="description" name="description" type="text" required minlength="3" maxlength="400"></textarea></p>
        <div id="gma500-add-product-ajax-result" class="gma500-ajax"></div>    
        <div id="submit-add-product" class="button button-primary gma500-button-submit">
            <i class="fa fa-plus-circle fa-lg"></i> Enregistrer
        </div>
    </div>  
    </form>

</div>