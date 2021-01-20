<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    $response = $api->getSellers();
?>
<?php if(!$response->error) 
  {
    $sellers = $response->sellers;
  ?>
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">
            <div class="col l12 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0">
                    <div class="card-content">
                        <div class="input-field">
                            <input type="text" name="productName" autocomplete="off" id="productName" placeholder="" onkeyup="filterProduct()">
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
                              <th>Image</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Mobile Number</th>
                              <th>Address</th>
                          </tr>
                        </thead>
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                              foreach ($sellers as $seller)
                              {
                                $image = $seller->sellerImage;
                                if (!isset($image) && empty($image))
                                  $image = 'src/img/user.png';
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td><a href='seller?sid=$seller->sellerId'><img src='$image' class='circle' style='width:50px; border:2px solid red'/></a></td>";
                                echo "<td class='blue-text darken-4'><a href='seller?sid=$seller->sellerId'>$seller->sellerFirstName $seller->sellerLastName</a></td>";
                                echo "<td style='font-weight:bold'>$seller->sellerEmail</td>";
                                echo "<td class='blue-text darken-4'>$seller->sellerContactNumber , $seller->sellerContactNumber1</td>";
                                echo "<td>$seller->sellerAddress</td>";
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
          <h4>No Sellers Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>