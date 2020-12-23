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
  		    <div class="card z-depth-0 blue lighten-3" style="margin: 10px; min-height: 490px;">
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
        </div>

            <!-- tr.innerHTML='<td><td><input type="text" id="sellId" readonly="readonly"></td></td>'; -->

        <div id="modal1" class="modal modal-fixed-footer">
		      <div class="modal-content">
  		    	<div class="input-field">
                <input type="text" autofocus name="productName" id="productName" placeholder="" onkeyup="filterProduct()" autofocus="off">
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

<!-- <script type="text/javascript"> --
>    // let BASE_URL = 'http://socialcodia.net/azmiunanistore/public/';

	function closeModal(){
		$('#modal1').modal('close');
	}

	function openModal(){
		$('#modal1').modal('open');
	}

	$(document).ready(function(){
    	$('.modal').modal();
  	});

  	function jsonToArray()
  	{
  		// var obj = JSON.parse(JS_Obj); 
				// var res = []; 
				// console.log(JS_Obj)
				// for(var i in obj) 
				// 	res.push(obj[i]); 
				// console.log(res);
  	}

	$(document).ready(function ()
	{
		$.ajax({
        headers:{  
           'token':"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzb2NpYWxjb2RpYS5jb20iLCJpYXQiOjE2MDgwNDE1NzUsInVzZXJfaWQiOjE5NH0.kitbeuKGwFAoXjRAogLQnZ6WsJkeLtvHQjPNEKZeEqA"
        },
        type:"get",
        url:"http://socialcodia.net/azmiunanistore/public/get/products",
        success:function(response)
        {
          console.log(response);
          if(!response.error)
          {
            products = response.products;
            var obj = JSON.parse(products); 

            for(let d=1; d<products.length; d++)
            {
            	var obj = JSON.parse(products[d]); 
				var res = []; 
				console.log(JS_Obj)
				for(var i in obj) 
					res.push(obj[i]); 
				console.log(res);
            }
          }
          else
          {
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    });

	$(document).ready(function ()
	{
    	var table = $('#example').DataTable({
        ajax: 'https://gyrocode.github.io/files/jquery-datatables/arrays.json',
        "paging":   false,
        "ordering": false,
        "info":     false,
        keys: {
           keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */ ]
        }
    });
    
    // Handle event when cell gains focus
    $('#example').on('key-focus.dt', function(e, datatable, cell){
        // Select highlighted row
        $(table.row(cell.index().row).node()).addClass('selected');
    });

    // Handle event when cell looses focus
    $('#example').on('key-blur.dt', function(e, datatable, cell){
        // Deselect highlighted row
        $(table.row(cell.index().row).node()).removeClass('selected');
    });
        
    // Handle key event that hasn't been handled by KeyTable
    $('#example').on('key.dt', function(e, datatable, key, cell, originalEvent){
        // If ENTER key is pressed
        if(key === 13){
            // Get highlighted row data
            var data = table.row(cell.index().row).data();
            console.log(data);
            // FOR DEMONSTRATION ONLY
            $("#example-console").html(data.join(', '));
            closeModal();
        }
    });       
});


</script> -->

<?php require_once dirname(__FILE__).'/include/footer.php'; ?>