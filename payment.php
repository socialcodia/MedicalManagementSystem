<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    if (isset($_GET['inum']))
    {
        $invoiceNumber = $_GET['inum'];
    }
    else
        header('LOCATION:invoices.php');

    $api = new API;
    $response = $api->getInvoiceByInvoiceNumber($invoiceNumber);
    $paymentsResponse = $api->getPaymentsByInvoiceNumber($invoiceNumber);
?>
<?php if(!$response->error) 
  {
    $invoice = $response->invoice;
  ?>
  
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">
            <div class="col l12 s12 m12" style="padding: 30px 10px 30px 10px;">
                <div class="card z-depth-0 orange lighten-3">
                    <div class="card-content deep-purple lighten-3">
                        <div class="row" style="margin-bottom: -10px;">
                            <div class="col l2 m2 s12">
                                <img src="<?php echo $invoice->sellerImage; ?>" class="responsive-img circle z-depth-3" style="border:3px solid white; width: 150px" >
                            </div>
                            <div class="col l10 m10 s12">
                                <table style="font-weight: bold" class="striped">
                                    <tr class="hoverable">
                                        <td id="sellerId" class="hide"><?php echo $invoice->sellerId; ?></td>
                                        <th>INVOICE NUMBER :</th><td id="invoiceNumber"><?php echo $invoice->invoiceNumber; ?></td>
                                        <th>INVOICE DATE :</th><td><?php echo $invoice->invoiceDate; ?></td>
                                    </tr>
                                    <tr class="hoverable">
                                        <th>NAME :</th><td id="sellerName"><?php echo $invoice->sellerName; ?></td>
                                        <th>Contact :</th><td><?php echo $invoice->sellerContactNumber; ?></td>
                                    </tr>
                                    <tr class="hoverable">
                                        <th>ADDRESS :</th><td><?php echo $invoice->sellerAddress; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-content deep-purple lighten-3">
                        <table style="font-weight: bold" class="striped">
                            <tr class="hoverable">
                                <th>Total Amount :</th><td><?php echo $invoice->invoiceAmount; ?></td>
                                <th>Paid Amount :</th><td id="invoicePaidAmount"><?php echo $invoice->invoicePaidAmount; ?></td>
                                <th>Remaining Amount :</th><td id="invoiceRemainingAmount"><?php echo $invoice->invoiceRemainingAmount; ?></td>
                            </tr>
                        </table>
                    </div>
                     <div class="card-content deep-purple lighten-1">
                            <div class="row">
                    <?php
                        if (!$paymentsResponse->error)
                        {
                            $payments = $paymentsResponse->payments;
                            $count = 1;
                            foreach ($payments as $pay) 
                            {
                            
                        ?>
                                <div class="col l18 offset-l2 m8 offset-m2 s12">
                                    <div class="card blue lighten-3" style="border-radius: 50px; border: 6px ridge black">
                                        <div class="card-content">
                                            <div class="row" style="margin-bottom: -0px; font-weight: bold">
                                                <div class="col l2 m2 s2">
                                                    <h6 style="font-weight: bold;"><?php echo $count; ?></h6>
                                                </div>
                                                <div class="col l4 m4 s4">
                                                    <h6 style="font-weight: bold;"><?php echo $pay->paymentDate; ?></h6>
                                                </div>
                                                <div class="col l2 m6 s6 right red" style="border-radius: 50px">
                                                    <h6 style="font-weight: bold;" class="center"><?php echo $pay->paymentAmount; ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                    <?php
                        $count++;
                        }
                    }
                    ?>

                            </div>
                        </div>
                </div>
                <div class="card row  col l8 offset-l2" style="border-radius: 40px">
                    <div class="card-content col l10 offset-l1">
                        <H3 class="center">Add Amount</H3>
                        <div class="row">
                            <div class="input-field">
                                <i class="material-icons prefix"><img src="src/icons/inr.png" width="40"></i>
                                <input type="number" name="paymentAmount" id="paymentAmount" style="text-transform:uppercase">
                                <label for="paymentAmount">Enter Product Name</label>
                            </div>
                            <div class="input-field center">
                                <button type="submit" style="width: 100%" class="btn red btn-large" onclick="alertMakePayment()" name="btnPayment" id="btnPayment">Accept Payment</button>
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
          <h4>No Invoice Details Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>