<div class="wrap">
    <div>
        <img class="gma500-banner-image" src="../wp-content/plugins/gma500/admin/assets/banner.jpg" alt="Géstion du matériel du club"/>
    </div>    
    <h1 class="gma500-h1">Géstion du matériel du club</h1>

    <!--ADD PRODUCT REDIRECTION-->
    <div id="gma500-admin-main-submit-add-product-page-button" class="button button-primary">
            <i class="fa fa-plus-circle fa-lg"></i> Ajouter du matos
    </div>
    <form id="gma500-admin-main-submit-add-product-page-form" class="gma500-form-hidden" action="?page=gma500_admin_menu_top" method="post">
        <input name="action" value="gma500_admin_addproduct_page"/>
    </form>    

    <!--SEARCH PRODUCT AJAX AND REDIRECTION-->
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
</div>    