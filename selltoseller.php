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
                <div class="row" style="margin-bottom: -30px;">
                  <div class="input-field col s6 m10 l10">
                    <select id="selectSeller">
                      <option value="0" disabled selected>Select Seller</option>
                    </select>
                    <label>Seller</label>
                  </div>
                  <div class="input-field col s6 m2 l2">
                      <button style="border: 2px solid white; border-radius: 20px; width: 100%; height: 50px;" onclick="setSeller()" class="btn red" id="btnSetSeller">Set Seller</button>
                      <button style="border: 2px solid white; border-radius: 20px; width: 100%; height: 50px; display: none" onclick="alertCancelCreatedInvoice()" class="btn red" id="btnRemSeller">Cancel</button>
                  </div>
                  <div class="col s4 m3 l3 center">
                    <img src="src/img/user.png" id="sellerProfileImage" class="responive-img circle" style="width: 100px; border: 2px solid blue">
                  </div>

                  <div class="col s8 m9 l19">
                    <h6 style="font-weight: bold">Name : <span id="viewSellerName"></span></h6>
                    <h6 style="font-weight: bold">Contact : <span id="viewSellerContact"></span></h6>
                    <h6 style="font-weight: bold">Address : <span id="viewSellerAddress"></span></h6>
                  </div>
                </div>
                
                <br>
		            
		        </div>
		      </div>
  		    <div class="card z-depth-0 blue lighten-3" style="margin: 10px; min-height: 490px;">
  	        <div class="card-content">
              <div class="input-field">
                    <input type="text" disabled="disabled" onclick="openModalAlert()" autofocus id="inputOpenModal" onkeyup="openModalTextController()" placeholder="">
                    <label for="productName">Enter Product Name</label>
                </div>
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
                    <input class="hide" type="hidden" id="inputInvoiceNumber">
  				        </tbody>
                </table>
  	        </div>
  		    </div>
          <div class="card z-depth-0 blue lighten-3" style="margin: 10px;">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m6  l6">
                  <h3 style="display: inline;">Total Price: </h3> <h3 style="font-weight: bold; display: inline;" id="htmlTotalPrice"></h3>
                </div>
                <div class="col s12 m6  l6 left">
                  <h3 style="display: inline;">Total Price: </h3> <h3 style="font-weight: bold; display: inline;" id="htmlDiscountPrice"></h3>
                </div>
              </div>
            </div>
          </div>
        </div>

            <!-- tr.innerHTML='<td><td><input type="text" id="sellId" readonly="readonly"></td></td>'; -->

        <div id="modal1" class="modal modal-fixed-footer">
		      <div class="modal-content">
  		    	<div class="input-field">
                <input type="text" name="productName" id="productName" autocomplete="off" placeholder="" onkeyup="filterProduct()">
                <label for="productName">Enter Product Name</label>
            </div>
  		    	<div id="results" class="scrollingdatagrid">	
    			    <table id="mstrTable" class="display" cellspacing="0" width="100%">
    				    <thead>
    				      <tr>
    			              <th>SR. NO</th>
    			              <th>Category</th>
    			              <th>Name</th>
    			              <th>Size</th>
    			              <th>Price</th>
    			              <th>Quantity</th>
    			              <th>Location</th>
    			              <th>Brand</th>
    			              <th>Manufacture</th>
    			              <th>Expire</th>
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
                                  echo "<td style='font-weight:bold'>$product->productName</td>";
                                  echo "<td style='font-weight:bold'>$product->productSize</td>";
                                  echo "<td style='font-weight:bold'>$product->productPrice</td>";
                                  echo "<td style='font-weight:bold'>$product->productQuantity</td>";
                                  echo "<td>$product->productLocation</td>";
                                  echo "<td>$product->productBrand</td>";
                                  echo "<td>$product->productManufacture</td>";
                                  echo "<td>$product->productExpire</td>";
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