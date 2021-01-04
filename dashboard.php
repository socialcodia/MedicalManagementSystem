<?php 
	require_once dirname(__FILE__).'/include/header.php';
	require_once dirname(__FILE__).'/include/api.php';
	require_once dirname(__FILE__).'/include/navbar.php';
	$api = new Api;
      $responseProductsCount = $api->getProductsCount();
      $responseProductsNoticeCount = $api->getNoticeProductsCount();
	$responseProductsExpiringCount = $api->getExpiringProductsCount();
      $responseTodaysSalesCount = $api->getTodaysSalesCount();
	$responseBrandsCount = $api->getBrandsCount();
      $productsCount = $responseProductsCount->products->productsCount;
      $productsNoticeCount = $responseProductsNoticeCount->products->productsNoticeCount;
	$productsExpiringCount = $responseProductsExpiringCount->products->productsExpiringCount;
	$todaysSalesCount = $responseTodaysSalesCount->sales->salesCount;
      $brandsCount = $responseBrandsCount->brands->brandsCount;
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l3 m4 s12">
            	<div class="card">
            		<div class="card-content blue lighten-3 white-text">
            			<h3 style="font-weight: bold;"><?php echo $productsCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Products</p>
            		</div>
            		<div class="card-action blue lighten-2 center">
            			<a class="white-text" href="products">More Information <i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l3 m4 s12">
            	<div class="card">
            		<div class="card-content blue lighten-3 white-text">
            			<h3 style="font-weight: bold;"><?php echo $todaysSalesCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Todays Sale</p>
            		</div>
            		<div class="card-action blue lighten-2 center">
            			<a class="white-text" href="salestoday">More Information <i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l3 m4 s12">
            	<div class="card">
            		<div class="card-content blue lighten-3 white-text">
            			<h3 style="font-weight: bold;"><?php echo $brandsCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Brands</p>
            		</div>
            		<div class="card-action blue lighten-2 center">
            			<a class="white-text" href="products">More Information <i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l3 m4 s12">
            	<div class="card">
            		<div class="card-content blue lighten-3 white-text">
            			<h3 style="font-weight: bold;"><?php echo $productsNoticeCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Notice</p>
            		</div>
            		<div class="card-action blue lighten-2 center">
            			<a class="white-text" href="productsnotice">More Information <i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l3 m4 s12">
                  <div class="card">
                        <div class="card-content blue lighten-3 white-text">
                              <h3 style="font-weight: bold;"><?php echo $productsExpiringCount; ?></h3>
                              <p style="font-weight: bold; font-size:20px;">Product Expiring</p>
                        </div>
                        <div class="card-action blue lighten-2 center">
                              <a class="white-text" href="expiringproducts">More Information <i class="material-icons tiny">open_in_new</i></a>
                        </div>
                  </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>