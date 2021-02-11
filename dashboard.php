<?php 
	require_once dirname(__FILE__).'/include/header.php';
	require_once dirname(__FILE__).'/include/api.php';
	require_once dirname(__FILE__).'/include/navbar.php';
	$api = new Api;
  	$responseProductsCount = $api->getProductsCount();
  	$responseProductsNoticeCount = $api->getNoticeProductsCount();
	$responseProductsExpiringCount = $api->getExpiringProductsCount();
  	$responseTodaysSalesCount = $api->getTodaysSalesCount();
  	$responseExpiredProductsCount = $api->getExpiredProductsCount();
	$responseBrandsCount = $api->getBrandsCount();
  	$productsCount = $responseProductsCount->products->productsCount;
  	$productsNoticeCount = $responseProductsNoticeCount->products->productsNoticeCount;
	$productsExpiringCount = $responseProductsExpiringCount->products->productsExpiringCount;
	$productsExpiredCount = $responseExpiredProductsCount->products->productsExpiredCount;
	$todaysSalesCount = $responseTodaysSalesCount->sales->salesCount;
  	$brandsCount = $responseBrandsCount->brands->brandsCount;
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1	 white-text">
            			<h3 style="font-weight: bold;"><?php echo $productsCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Products</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="products">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;"><?php echo $todaysSalesCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Todays Sale</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="salestoday">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;"><?php echo $brandsCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Brands</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="products">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;"><?php echo $productsNoticeCount; ?></h3>
            			<p style="font-weight: bold; font-size:20px;">Notice</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="productsnotice">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
                  <div class="card hoverable">
                        <div class="card-content blue lighten-1 white-text">
                              <h3 style="font-weight: bold;"><?php echo $productsExpiringCount; ?></h3>
                              <p style="font-weight: bold; font-size:20px;">Expiring</p>
                        </div>
                        <div class="card-action blue darken-2 center">
                              <a class="white-text" href="expiringproducts">More<i class="material-icons tiny">open_in_new</i></a>
                        </div>
                  </div>
            </div>
            <div class="col l2 m4 s12">
                  <div class="card hoverable">
                        <div class="card-content blue lighten-1 white-text">
                              <h3 style="font-weight: bold;"><?php echo $productsExpiredCount; ?></h3>
                              <p style="font-weight: bold; font-size:20px;">Expired</p>
                        </div>
                        <div class="card-action blue darken-2 center">
                              <a class="white-text" href="expiredproducts">More<i class="material-icons tiny">open_in_new</i></a>
                        </div>
                  </div>
            </div>
        </div>
        <div class="row">
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chatSalesRecordOfDays" width="400" height="400"></canvas>
        		</div>
        	</div>
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chatSalesRecordOfMonths" width="400" height="400"></canvas>
        		</div>
        	</div>
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chartTopProductsRecord" width="400" height="400"></canvas>
        		</div>
        	</div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>