<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l10 offset-l1 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col l4">
                                <div class="input-field col s12">
                                    <select id="selectBrand">
                                      <option value="" disabled selected>Select Brand</option>
                                    </select>
                                    <label>Brand</label>
                                </div>
                            </div>
                            <div class="col l4">
                                <div class="input-field col s12">
                                    <select id="selectCategory">
                                      <option value="" disabled selected>Select Category</option>
                                    </select>
                                    <label>Category</label>
                                </div>
                            </div>
                            <div class="col l4">
                                <div class="input-field col s12">
                                    <select id="selectSize">
                                      <option value="" disabled selected>Select Size</option>
                                    </select>
                                    <label>Size</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <input type="text" class="autocomplete" name="productName" id="productName">
                            <label for="productName blue-text">Enter Product Name</label>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue" onclick="addProduct()" name="btnAddProduct" id="btnAddProduct">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>