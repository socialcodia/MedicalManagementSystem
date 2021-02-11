<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    $api = new API;
    // $response = $api->getNoticeProducts();
    $response = true;
?>
<?php if(!$response) 
  {
    $products = $response->products;
  ?>
  
    <div class="socialcodia" style="margin-top: -30px">
        <div class="row">

        </div>
    </div>
 <?php }
  else
  {
    ?>

    <div class="socialcodia center">
          <h4>Working On This</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>