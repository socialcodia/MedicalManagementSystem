<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    $response = $api->getInvoices();
?>
<?php if(!$response->error) 
  {
    $invoices = $response->invoices;
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
                              <th>Invoice Number</th>
                              <th>Status</th>
                              <th>Total Amount</th>
                              <th>Paid Amount</th>
                              <th>Remaining Amount</th>
                              <th>Invoice Date</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                              foreach ($invoices as $invoice)
                              {
                                $color = 'blue';
                                $image = $invoice->sellerImage;
                                if (!isset($image) && empty($image))
                                  $image = 'src/img/user.png';
                                $invoicePaidAmount = (int) $invoice->invoicePaidAmount;
                                $invoiceRemainingAmount = (int) $invoice->invoiceRemainingAmount;
                                if (empty($invoicePaidAmount))
                                    $invoicePaidAmount = 0;
                                if (empty($invoiceRemainingAmount))
                                  $invoiceRemainingAmount = 0;
                                if ($invoice->invoiceStatus=='UNPAID')
                                    $color = 'red';
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td><img src='$image' class='circle' style='width:50px; border:2px solid red'/></td>";
                                echo "<td class='blue-text darken-4'>$invoice->sellerName</td>";
                                echo "<td style='font-weight:bold'>$invoice->invoiceNumber</td>";
                                echo "<td class='blue-text darken-4 chip $color white-text' style='margin-top:25px;'>$invoice->invoiceStatus</td>";
                                echo "<td>$invoice->invoiceAmount</td>";
                                echo "<td>$invoicePaidAmount</td>";
                                echo "<td>$invoiceRemainingAmount</td>";
                                echo "<td class='blue-text darken-4'>$invoice->invoiceDate</td>";
                                echo '<td><a href="invoice?inum='.$invoice->invoiceNumber.'" style="border: 1px solid white;border-radius: 50%;" class="btn blue" data-position="top" data-tooltip="View Invoice"><i class="material-icons white-text">remove_red_eye
                                    </i></a>';
                                echo '<a href="payment?inum='.$invoice->invoiceNumber.'" style="border: 1px solid white;border-radius: 50%;" class="btn red" data-position="top" data-tooltip="Pay Amount"><i class="material-icons white-text">attach_money
                                </i></a></td>';
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
          <h4>No Invoices Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>