<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    $response = $api->getTodaysSalesRecord();
    // $sales = $response->sales;
    // print_r($products);
?>
  <?php if(!$response->error) 
  {
    $sales = $response->sales;
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
                              <th>Total Price</th>
                              <th>Sale Price</th>
                              <th>Brand</th>
                              <th>Manufacture</th>
                              <th>Expire</th>
                              <th>Sales Time</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                            $totalEndSellPrice = 0;
                            $totalEndPrice = 0;
                              foreach ($sales as $product)
                              {
                                $t = strtotime($product->createdAt);
                                // $t = $product->saleQuanitty*$product->productPrice;
                                $totalPrice = $product->saleQuanitty*$product->productPrice;
                                $totalEndPrice = $totalEndPrice+$t;
                                $totalEndSellPrice = $totalEndSellPrice+$product->salePrice;

                                echo "<tr id='rowId$product->saleId'>";
                                echo "<td>$count</td>";
                                echo "<td>$product->productCategory</td>";
                                echo "<td class='blue-text darken-4'>$product->productName</td>";
                                echo "<td style='font-weight:bold'>$product->productSize</td>";
                                echo "<td>$product->productPrice</td>";
                                echo "<td>$product->saleQuanitty</td>";
                                echo "<td class='blue-text darken-4'>$totalPrice</td>";
                                echo "<td>$product->salePrice </td>";
                                echo "<td class='blue-text darken-4'>$product->productBrand</td>";
                                echo "<td>$product->productManufacture</td>";
                                echo "<td class='red-text'>$product->productExpire</td>";
                                echo "<td class='center'>".date('H:i',$t);".</td>";
                                echo '<td><button id="btnDelete'.$product->saleId.'" value="'.$product->saleId.'" onclick="alertDeleteSaleProduct(this.value)" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">delete_forever</i></button></td>';
                                $count++;
                                echo "</tr>";
                              }
                            ?>
                          </tr>
                        </tbody>
                        </table>
                        <div class="row green lighten-4">
                          <div class="col l6 m6 s6 center">
                            <h5>Total Price = <span class="blue-text" style="font-weight: bold"><?php echo $totalEndPrice; ?></span></h5>
                          </div>
                          <div class="col l6 m6 s6 center">
                            <h5>Total Sell Price = <span class="blue-text" style="font-weight: bold"><?php echo $totalEndSellPrice; ?></span></h5>
                          </div>
                        </div>
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
          <h4>No Sales Today</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>