<div class="wrap">
    <h1>Ajouter du materiel</h1>
    <form id="form-add-product" action="add_product">
      <div style="display:flex;flex-flow:row wrap-reverse;width:100%;">
        <div style="min-width:200px;padding:10px">
            <p>NÚMERO DE SÉRIE*:<br /><input  id="serialNumber" name="serialNumber" type="text" required minlength="3"/></p>
            <p>ID GMA*:<br /><input  id="idGMA" name="idGMA" type="text" required minlength="3"/></p>
            <p>MARQUE*:<br /><input  id="marque" name="marque" type="text" required minlength="3"/></p>
        </div>  
        <div style="min-width:200px;display:flex;flex-flow:column;justify-content:center;padding:10px">
            <div style="display:flex;justify-content:center">
                <img id="productImage" class="product-image" src="../wp-content/plugins/gma500/admin/assets/default-product.jpg" alt="Image du matériel">
                <img class="shadow" alt="shadow" id="shadowImg" style="display:none">
                <canvas class="shadow" id="shadowCanvas"></canvas>
                <input  class="shadow" type="file" id="fileInput">  
            </div>
            <div style="display:flex;flex-flow:row;justify-content:center">
                <input style="margin:5px" id="upload" type="button" class="button button-primary" value="Upload" />
                <input style="margin:5px" id="clear" type="button" class="button button-primary" value="Clear" />
                <input style="margin:5px" id="rotate" type="button" class="button button-primary" value="Rotate" />
            </div>
        </div>        
      </div> 
      <p><input id="test" type="button" class="button button-primary" value="Enregistrer" /></p>
    </form>

</div>