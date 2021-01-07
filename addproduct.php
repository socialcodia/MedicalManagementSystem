<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l10 offset-l1 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0">
                    <div class="card-content">
                        <div class="row">
                            <div class="col l3 s12 m6">
                                <div class="input-field">
                                    <select id="selectBrand">
                                      <option value="0" disabled selected>Select Brand</option>
                                    </select>
                                    <label>Brand</label>
                                </div>
                            </div>
                            <div class="col l3 s12 m6">
                                <div class="input-field">
                                    <select id="selectCategory">
                                      <option value="0" disabled selected>Select Category</option>
                                    </select>
                                    <label>Category</label>
                                </div>
                            </div>
                            <div class="col l3 s12 m6">
                                <div class="input-field">
                                    <select id="selectSize">
                                      <option value="0" disabled selected>Select Size</option>
                                    </select>
                                    <label>Size</label>
                                </div>
                            </div>
                            <div class="col l3 s12 m6">
                                <div class="input-field">
                                    <select id="selectLocation">
                                      <option value="0" disabled selected>Select Location</option>
                                    </select>
                                    <label>Location</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">store</i>
                            <input type="text" name="productName" id="productName" style="text-transform:uppercase">
                            <label for="productName">Enter Product Name</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">monetization_on</i>
                                <input  id="productPrice" type="number" class="validate">
                                <label for="productPrice">Product Price</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">loupe</i>
                                <input  id="productQuantity" type="number" class="validate">
                                <label for="productQuantity">Product Quantity</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l6">
                                <div class="input-field col l6">
                                    <select id="manMonth">
                                        <option value="0" disabled selected>Month</option>
                                        <option value='01'>January</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                    <label>Manufacture Month</label>
                                </div>
                                <div class="input-field col l6">
                                    <select id="manYear">
                                        <option value="0" disabled selected>Year</option>
                                        <option value='2022'>2022</option>
                                        <option value='2021'>2021</option>
                                        <option value='2020'>2020</option>
                                        <option value='2019'>2019</option>
                                        <option value='2018'>2018</option>
                                        <option value='2017'>2017</option>
                                        <option value='2016'>2016</option>
                                        <option value='2015'>2015</option>
                                        <option value='2014'>2014</option>
                                        <option value='2013'>2013</option>
                                    </select>
                                    <label>Manufacture year</label>
                                </div>
                            </div>
                            <div class="col l6">
                                <div class="input-field col l6">
                                    <select id="expMonth">
                                        <option value="0" disabled selected>Month</option>
                                        <option value='01'>January</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                    <label>Expired Month</label>
                                </div>
                                <div class="input-field col l6">
                                    <select id="expYear">
                                        <option value="0" disabled selected>Year</option>
                                        <option value='2024'>2024</option>
                                        <option value='2023'>2023</option>
                                        <option value='2022'>2022</option>
                                        <option value='2021'>2021</option>
                                        <option value='2020'>2020</option>
                                        <option value='2019'>2019</option>
                                        <option value='2018'>2018</option>
                                        <option value='2017'>2017</option>
                                        <option value='2016'>2016</option>
                                        <option value='2015'>2015</option>
                                    </select>
                                    <label>Expired Year</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue btn-large" style="width: 50%" onclick="addProduct()" name="btnAddProduct" id="btnAddProduct">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>