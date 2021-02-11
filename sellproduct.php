<?php 
	require_once dirname(__FILE__).'/include/header.php';
	require_once dirname(__FILE__).'/include/api.php';
	require_once dirname(__FILE__).'/include/navbar.php';

	$api = new API;

	$response = $api->getProducts();
?>
<style type="text/css">
tr.normal td {
    color: black;
    background-color: white;
}
tr.highlighted td {
    color: white;
    background-color: red;
}
</style>

  <?php if(!$response->error) 
  {
    $products = $response->products;
  ?>

    <div class="socialcodia">
        <div class="row">
        	<div class="card z-depth-0" style="margin: 10px">
		        <div class="card-content">
		            <div class="input-field">
		                <input type="text" autofocus id="inputOpenModal" onkeyup="openModalTextController()" placeholder="">
		                <label for="productName">Enter Product Name</label>
		            </div>
		        </div>
		      </div>
  		    <div class="card z-depth-0 blue lighten-3" style="margin: 10px; min-height: 390px;">
  	        <div class="card-content">
  	            <table id="productTable" class="highlight responsive-table ">
                  <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Discount(%)</th>
                        <th>Sell Price</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="SellRecordTableBody" style="font-weight: bold;">
  				        </tbody>
                </table>
  	        </div>
  		    </div>
          <div class="card z-depth-0 blue lighten-3" style="margin: 10px;">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m6  l6 left">
                  <h3 style="display: inline;">Total Price: </h3> <h3 style="font-weight: bold; display: inline;" id="htmlTotalPrice"></h3>
                </div>
                <div class="col s12 m6  l6 right">
                  <h3 style="display: inline;">Sell Price: </h3> <h3 style="font-weight: bold; display: inline;" id="htmlDiscountPrice"></h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="modal1" class="modal modal-fixed-footer">
		      <div class="modal-content">
  		    	<div class="input-field">
                <input type="text" name="productName" id="productName" autocomplete="off" placeholder="" onkeyup="filterProduct()">
                <label for="productName">Enter Product Name</label>
            </div>
  		    	<div id="results" class="scrollingdatagrid">	
    			    <table id="mstrTable" tabindex="0" class="display" cellspacing="0" width="100%">
    				    <thead>
    				      <tr>
    			              <th>SR. NO</th>
    			              <th>CATEGORY</th>
    			              <th>NAME</th>
    			              <th>SIZE</th>
    			              <th>PRICE</th>
    			              <th>QUAN</th>
    			              <th>LOC</th>
    			              <th>BRAND</th>
    			              <th>MAN</th>
    			              <th>EXP</th>
    				      </tr>
    				    </thead>
    				    <tbody>
                  <?php
                  $count = 1;
                    foreach ($products as $product)
                    {
                      if ($product->productQuantity>0)
                      {
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td class='hide' id='$product->productId'>$product->productId</td>";
                        echo "<td>$product->productCategory</td>";
                        echo "<td style='font-weight:bold' class='blue-text darken-4'>$product->productName</td>";
                        echo "<td style='font-weight:bold'>$product->productSize</td>";
                        echo "<td class='blue-text' style='font-weight:bold'>$product->productPrice</td>";
                        echo "<td style='font-weight:bold'>$product->productQuantity</td>";
                        echo "<td style='font-weight:bold;'>$product->productLocation</td>";
                        echo "<td class='blue-text darken-4'>$product->productBrand</td>";
                        echo "<td>$product->productManufacture</td>";
                        echo "<td class='red-text'>$product->productExpire</td>";
                        $count++;
                        echo "</tr>";
                      }
                    }
                    ?>
    				    </tbody>
    				  </table>
  			    </div>	
		      </div>
		  </div>

      <div id="modalSellOnCredit" class="modal modal-fixed-footer" style="border:8px ridge blue; border-radius: 40px; box-shadow: inset 0 0 0 5px blue, inset 0 0 0 10px white; ">
        <h4 class="blue white-text center darken-4" style="margin: 0px">Sell On Credit</h4>
          <div class="modal-content" style="margin: 0px; padding: 10px">
            <div class="row green lighten-5" style="">
              <div class="col s12 m6 l6">
                <div class="input-field">
                  <i class="material-icons blue-text darken-4 prefix">person</i>
                  <input type="text" name="customerName" id="customerName" required="required">
                  <label for="customerName">Enter Customer Name</label>
                </div>
              </div>
              <div class="col s12 m6 l6">
                <div class="input-field">
                  <i class="material-icons blue-text darken-4 prefix">call</i>
                  <input type="number" name="customerMobile" id="customerMobile" required="required">
                  <label for="customerMobile">Enter Customer Mobile Number</label>
                </div>
              </div>
              <div class="col s12 m12 12">
                <div class="input-field">
                  <i class="material-icons blue-text darken-4 prefix">address</i>
                  <input type="text" name="customerAddress" id="customerAddress" required="required">
                  <label for="customerAddress">Enter Customer Address</label>
                </div>
              </div>
                <div class="center">
                  <div class="col l4 m4 s12">
                    <div class="input-field">
                      <h5 style="display: inline;">Sell Price: </h5> <h5 style="font-weight: bold; display: inline;" id="htmlCreditDiscountPrice"></h5>
                    </div>
                  </div>
                   <div class="col l4 m4 s12">
                    <div class="input-field">
                      <i class="material-icons blue-text darken-4 prefix">attach_money</i>
                      <input type="number" name="paidAmount" onkeyup="creditPaidAmountChangeEvent()" id="paidAmount" value="0">
                      <label for="paidAmount">Enter Paid Amount</label>
                    </div>
                  </div>
                  <div class="col l4 m3 s12">
                    <div class="input-field">
                      <h5 style="display: inline;">Remaining Amount: </h5> <h5 style="font-weight: bold; display: inline;" id="htmlCreditRemainingAmount"></h5>
                    </div>
                  </div>
                </div>
                 <div class="col s12 m12 12">
                    <div class="input-field">
                      <i class="material-icons blue-text darken-4 prefix">description</i>
                      <input type="text" name="customerDescription" id="customerDescription">
                      <label for="customerDescription">Enter Any Description</label>
                    </div>
                  </div>
                  <div class="col s12 m6 16 offset-m3 offset-l3">
                    <div class="input-field">
                      <button class="btn btn-large blue darken-4" onclick="alertSellOnCredit()" id="btnSellOnCredit" style="width: 100%;  border-radius:40px;">Add Credit Record</button>
                    </div>
                  </div>
              </div>
            <div class="divider"></div>
            <div class="row">
              <table class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                        <th>SR. NO</th>
                        <th>NAME</th>
                        <th>SIZE</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>Sell Price</th>
                        <th>BRAND</th>
                  </tr>
                </thead>
                <tbody id="SellOnCreditTableBody" style="font-weight: bold">
                </tbody>
              </table>
            </div>
          </div>
      </div>

    </div>
  <?php }
  else
  {
    ?>

    <div class="socialcodia center">
          <h4>No Products To Sale</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>