<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    if (isset($_GET['inum']))
      $invoiceNumber = $_GET['inum'];
    else
      header('LOCATION:invoices.php');
    $api = new API;
    $response = $api->getInvoiceUrlByInvoiceNumber($invoiceNumber);
?>

<?php if(!$response->error) 
  {
    $invoice = $response->invoice;
  ?>
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">
            <div class="col l12 s12 m12" style="padding: 30px 0px 30px 10px;">
              <embed src="<?php echo $invoice->invoiceUrl; ?>" class="col s12 l12 m12" height="650"/>
            </div>
        </div>
    </div>


<?php }
  else
  {
    ?>

    <div class="socialcodia center">
          <h4>No Invoice Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>