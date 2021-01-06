<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    if (isset($_POST['btnAddSeller']))
    {
        $sellerFirstName = $_POST['sellerFirstName'];
        $sellerLastName = $_POST['sellerLastName'];
        $sellerEmail = $_POST['sellerEmail'];
        $sellerContactNumber = $_POST['sellerContactNumber'];
        $sellerContactNumber1 = $_POST['sellerContactNumber1'];
        $sellerImage = $_FILES['image'];
        $sellerAddress = $_POST['sellerAddress'];
        $api = new Api;
        $result = $api->addSeller($sellerFirstName,$sellerLastName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress);
        $message = $result->message;
    }

?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l10 offset-l1 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0">
                    <div class="card-content">           
                        <div class="row">
                            <h5 style="font-weight: bold;" class="center red-text">
                                <?php
                                    if (isset($message) && !empty($message))
                                        echo $message;
                                ?>
                            </h5>
                            <form method="post" enctype="multipart/form-data">
                                <div class="col s12 center">
                                    <input id="image" type="file" onchange="previewSellerImage(this);" name="image" class="hide">
                                    <label for="image"><img src="src/img/user.png" style="height: 160px; width: 160px; object-fit: cover; border: 2px solid blue;" id="sellerImage" class="responsive-img circle" width="110" alt=""></label>
                                </div>
                                <div class="input-field col s12 l6 m6">
                                    <i class="material-icons prefix">person</i>
                                    <input required="required"  id="sellerFirstName" type="text" name="sellerFirstName" class="validate">
                                    <label for="sellerFirstName">Enter First Name</label>
                                </div>
                                <div class="input-field col s12 l6 m6">
                                    <i class="material-icons prefix">person</i>
                                    <input required="required"  id="sellerLastName" type="text" name="sellerLastName" class="validate">
                                    <label for="sellerLastName">Enter Last Name</label>
                                </div>
                                <div class="input-field col s12 l12 m6">
                                    <i class="material-icons prefix">email</i>
                                    <input  id="sellerEmail" type="text"  name="sellerEmail" class="validate">
                                    <label for="sellerEmail">Enter Email Address</label>
                                </div>
                                <div class="input-field col s12 l6 m6">
                                    <i class="material-icons prefix">call</i>
                                    <input required="required" id="sellerContactNumber" type="number"  name="sellerContactNumber" class="validate">
                                    <label for="sellerContactNumber">Enter Mobile Number</label>
                                </div>
                                <div class="input-field col s12 l6 m6">
                                    <i class="material-icons prefix">call</i>
                                    <input  id="sellerContactNumber1" type="number"  name="sellerContactNumber1" class="validate">
                                    <label for="sellerContactNumber1">Enter Another Mobile Number</label>
                                </div>
                                <div class="input-field col s12 l12 m6">
                                    <i class="material-icons prefix">address</i>
                                    <textarea required="required" name="sellerAddress" id="" cols="30" rows="10" maxlength="1000" style="max-height: 90px; min-height: 90px; width: 90%;" class="materialize-textarea" placeholder="Address"></textarea>
                                </div>
                                <div class="input-field center col s12 l12 m6">
                                    <button type="submit" class="btn blue btn-large" style="width: 50%; min" onclick="addSeller()" name="btnAddSeller" id="btnAddSeller">Add Seller</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>