<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    $response = $api->getCredits();
?>
<?php if(!$response->error) 
  {
    $credits = $response->credits;
    // print_r($credits);
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
                              <th>Name</th>
                              <th>Status</th>
                              <th>Total Amount</th>
                              <th>Paid Amount</th>
                              <th>Remaining Amount</th>
                              <th>Credit Date</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="font-family: holo">
                          <tr>
                            <?php
                            $count = 1;
                              foreach ($credits as $credit)
                              {
                                $creditorName =  $credit->creditor->creditorName;
                                $color = 'blue';
                                $creditPaidAmount = (int) $credit->creditPaidAmount;
                                $creditRemainingAmount = (int) $credit->creditRemainingAmount;
                                if (empty($creditPaidAmount))
                                    $creditPaidAmount = 0;
                                if (empty($creditRemainingAmount))
                                  $creditRemainingAmount = 0;
                                if ($credit->creditStatus=='UNPAID')
                                    $color = 'red';
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td class='blue-text darken-4'>$creditorName</td>";
                                echo "<td class='blue-text darken-4 chip $color white-text' style='margin-top:17px;'>$credit->creditStatus</td>";
                                echo "<td>$credit->creditTotalAmount</td>";
                                echo "<td>$creditPaidAmount</td>";
                                echo "<td>$creditRemainingAmount</td>";
                                echo "<td class='blue-text darken-4'>$credit->creditDate</td>";
                                echo '<td><a href="credit?cid='.$credit->creditId.'" style="border: 1px solid white;border-radius: 50%;" class="btn blue" data-position="top" data-tooltip="View credit"><i class="material-icons white-text">remove_red_eye
                                    </i></a>';
                                // echo '<a href="payment?cid='.$credit->creditId.'" style="border: 1px solid white;border-radius: 50%;" class="btn red" data-position="top" data-tooltip="Pay Amount"><i class="material-icons white-text">attach_money
                                // </i></a></td>';
                                $count++;
                                echo "</tr>";

                                //add a table here and with table heading and data and hide it. on click of above table show this table.
                                // with some animation, to make it look better
                                // Also dont forgot add full seller information before product table start like creditorName, creditor Address etc
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
          <h4>No Credits Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>