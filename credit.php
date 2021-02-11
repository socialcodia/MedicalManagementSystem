<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    if (isset($_GET['cid']))
    {
        $creditId = $_GET['cid'];
    }
    else
        header('LOCATION:credits');

    $api = new API;
    $response = $api->getCreditById($creditId);
    $creditorImage = 'src/img/user.png';
    $paymentsResponse = $api->getPaymentsByCreditId($creditId);
?>
<?php if(!$response->error) 
  {
    $credit = $response->credit;
    $creditorName = $credit->creditor->creditorName;
    $creditorMobile = $credit->creditor->creditorMobile;
    $products = $credit->products;
    $payments = $paymentsResponse->payments;
  ?>
  
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">
            <div class="col l12 s12 m12" style="padding: 30px 10px 30px 10px;">
                <div class="card z-depth-0 orange lighten-3">
                    <div class="card-content deep-purple lighten-3">
                        <div class="row" style="margin-bottom: -10px;">
                            <div class="col l2 m2 s12">
                                <img src="<?php echo $creditorImage; ?>" class="responsive-img circle z-depth-3" style="border:3px solid white; width: 150px" >
                            </div>
                            <div class="col l10 m10 s12">
                                <table style="font-weight: bold" class="striped">
                                    <tr class="hoverable">
                                        <!-- <td id="sellerId" class="hide"><?php echo $credit->sellerId; ?></td> -->
                                        <th>NAME :</th><td id="creditorName"><?php echo $creditorName; ?></td><td id="creditId" class="hide"><?php echo $credit->creditId; ?></td>
                                    </tr>
                                    <tr class="hoverable">
                                        <th>MOBILE :</th><td id="creditorMobile"><?php echo $creditorMobile; ?></td>
                                        <th>CREDIT DATE :</th><td id="creditDate"><?php echo $credit->creditDate; ?></td>
                                    </tr>
                                    <tr class="hoverable">
                                        <th>Description :</th><td><?php echo $credit->creditDescription; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                     <div class="card-content white lighten-4" style="border:10px solid #b39ddb;">
                            <div class="row">
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
                              <th>Discount</th>
                              <th>Sale Price</th>
                              <th>Brand</th>
                              <th>Manufacture</th>
                              <th>Expire</th>
                          </tr>
                        </thead>
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                            $totalEndSellPrice = 0;
                            $totalEndPrice = 0;
                              foreach ($products as $product)
                              {
                                $totalPrice = $product->saleQuantity*$product->productPrice;
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td>$product->productCategory</td>";
                                echo "<td class='blue-text darken-4'>$product->productName</td>";
                                echo "<td style='font-weight:bold'>$product->productSize</td>";
                                echo "<td>$product->productPrice</td>";
                                echo "<td>$product->saleQuantity</td>";
                                echo "<td class='blue-text darken-4'>$totalPrice</td>";
                                echo "<td>$product->saleDiscount"."%"."</td>";
                                echo "<td>$product->salePrice </td>";
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
                                            <div class="card-content deep-purple lighten-3">
                        <table style="font-weight: bold" class="striped">
                            <tr class="hoverable">
                                <th>Total Amount :</th><td><?php echo $credit->creditTotalAmount; ?></td>
                                <th>Paid Amount :</th><td id="creditPaidAmount"><?php echo $credit->creditPaidAmount; ?></td>
                                <th>Remaining Amount :</th><td id="creditRemainingAmount"><?php echo $credit->creditRemainingAmount; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card z-depth-0 col l6 s12 m6" style="border-radius: 40px">
                    <div class="card-conent ">
                        <H3 class="center">All Payments</H3>
                        <?php
                          $count = 1;
                          foreach ($payments as $payment) {
                            ?>
                            <div class="card" style="border-radius: 30px; margin: 10px;">
                              <div class="card-content blue lighten-3" style="padding: 0px; border-radius: 30px;">
                                  <div class="row center" style="">
                                    <div class="col s1 m1 l1 red lighten-1" style="padding: 10px; border-radius: 30px;">
                                      <?php echo $count; ?>
                                    </div>
                                    <div class="col s7 m7 l7 blue lighten-3" style="font-weight: bold;padding: 10px; ">
                                      <?php echo "₹".$payment->paymentAmount; ?>
                                    </div>
                                    <div class="col s4 m4 l4 orange lighten-3" style="padding: 10px; border-radius: 30px;">
                                      <?php echo $payment->paymentDate; ?>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <?php
                            $count++;
                          }
                        ?>
                    </div>
                </div>
                <div class="col l6 s12 m6" >
                    <div class="card z-depth-0 row" style="margin: 10px; border-radius: 40px;" >
                      <div class="card-content col l12 s12 m12">
                        <H3 class="center" style="margin: 0px">Add Amount</H3>
                        <div>
                            <div class="input-field">
                                <i class="material-icons prefix"><img src="src/icons/inr.png" class="hoverable circle" width="40"></i>
                                <input type="number" name="paymentAmount" id="paymentAmount" style="text-transform:uppercase">
                                <label for="paymentAmount">Enter Amount</label>
                            </div>
                            <div class="input-field center">
                                <button type="submit" style="width: 60%; border-radius: 30px;" class="btn red btn-large" onclick="alertAcceptCreditPayment()" name="btnPayment" id="btnPayment">Accept Payment</button>
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
          <h4>No Credit Details Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>