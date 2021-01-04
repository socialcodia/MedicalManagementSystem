<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l6 s12 m6" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0" style="margin:20px">
                    <div class="card-content">
                        <p class="center card-title" style="font-weight:bold">Add Brand</p>
                        <div class="input-field">
                            <input type="text" style="text-transform:uppercase" name="brandName" id="brandName">
                            <label for="brandName">Enter Brand Name</label>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue" onclick="addBrand()" name="btnAddBrand" id="btnAddBrand">Add Brand</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l6 s12 m6" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0" style="margin:20px">
                    <div class="card-content">
                        <p class="center card-title" style="font-weight:bold">Add Category</p>
                        <div class="input-field">
                            <input type="text" style="text-transform:uppercase" name="categoryName" id="categoryName">
                            <label for="categoryName">Enter Category Name</label>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue" onclick="addCategory()" name="btnAddCategory" id="btnAddCategory">Add Category</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l6 s12 m6" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0" style="margin:20px">
                    <div class="card-content">
                        <p class="center card-title" style="font-weight:bold">Add Size</p>
                        <div class="input-field">
                            <input type="text" style="text-transform:uppercase" name="sizeName" id="sizeName" placeholder="50Ml or 15GM">
                            <label for="sizeName">Enter Size Name</label>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue" onclick="addSize()" name="btnAddSize" id="btnAddSize">Add Size</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l6 s12 m6" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0" style="margin:20px">
                    <div class="card-content">
                        <p class="center card-title" style="font-weight:bold">Add Location</p>
                        <div class="input-field">
                            <input type="text" style="text-transform:uppercase" name="locationName" id="locationName">
                            <label for="locationName">Enter Location Name</label>
                        </div>
                        <div class="input-field center">
                            <button type="submit" class="btn blue" onclick="addLocation()" name="btnAddLocation" id="btnAddLocation">Add Location</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>