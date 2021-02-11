<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    $response = $api->getExpiredProducts();
?>

<?php if(!$response->error) 
  {
    $products = $response->products;
  ?>
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">
            <div class="col l12 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0">
                    <div class="card-content">
                        <div class="input-field">
                            <input type="text" name="productName" id="productName" placeholder="" onkeyup="filterProduct()">
                            <label for="productName">Enter Product Name</label>
                        </div>
                    </div>
                </div>
                <div id="productList">
                     <div class="card z-depth-0">
                       <table id="mstrTable" class="highlight responsive-table ">
                        <thead>
                          <tr>
                              <th>Sr No</th>
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
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                              foreach ($products as $product)
                              {
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td>$product->productCategory</td>";
                                echo "<td class='blue-text darken-4'>$product->productName</td>";
                                echo "<td style='font-weight:bold'>$product->productSize</td>";
                                echo "<td class='blue-text darken-4'>$product->productPrice</td>";
                                echo "<td>$product->productQuantity</td>";
                                echo "<td>$product->productLocation</td>";
                                echo "<td class='blue-text darken-4'>$product->productBrand</td>";
                                echo "<td>$product->productManufacture</td>";
                                echo "<td class='red-text'>$product->productExpire</td>";
                                $count++;
                                echo "</tr>";
                              }
                            ?>
                          </tr>
                        </tbody>
                    </table>
                     </div>
                </div>
            </div>
        </div>
    </div>

  <?php }
  else
  {
    ?>

    <div class="socialcodia center">
          <h4>No Expired Products Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>