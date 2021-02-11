<ul id="slide-out" class="sidenav collapsible sidenav-fixed z-depth-0" style=" top:55px; font-weight:bold;">
        <li class="hide-on-large-only">
            <div class="user-view">
                  <div class="background">
                    <img src="img/bg.jpg" style="background-size: cover;">
                  </div>
                  <a href="<?php echo $_SESSION['username']; ?>"><img class="circle" src="<?php echo $_SESSION['image'];; ?>"></a>
                  <a href="#!"><span class="white-text name"><?php echo $_SESSION['name']; ?></span></a>
                  <a href="#!"><span class="white-text email"><?php echo $_SESSION['email']; ?></span></a>
            </div>
        </li>
        <li><a href="dashboard"><i class="material-icons"><img src="src/icons/home.png" width="25" alt=""></i>Dashboard</a></li>
        <li><a href="sell"><i class="material-icons"><img src="src/icons/sell.png" width="25" alt=""></i>Sell Product</a></li>
        <li><a href="salestoday"><i class="material-icons"><img src="src/icons/events.png" width="25" alt=""></i>Sales Today</a></li>
        <li><a href="salesall"><i class="material-icons"><img src="src/icons/sales_all.png" width="25" alt=""></i>Sales All</a></li>
        <li><a href="products"><i class="material-icons"><img src="src/icons/products.png" width="25" alt=""></i> All Products</a></li>
        <li><a href="productsrecord"><i class="material-icons"><img src="src/icons/category.png" width="25" alt=""></i> Products Record</a></li>
        <li><a href="productsnotice"><i class="material-icons"><img src="src/icons/notice_1.png" width="25" alt=""></i> Products Notice</a></li>
        <li><a href="expiringproducts"><i class="material-icons"><img src="src/icons/notice.png" width="25" alt=""></i> Expiring Products</a></li>
        <li><a href="expiredproducts"><i class="material-icons"><img src="src/icons/danger.png" width="25" alt=""></i> Expired Products</a></li>
        <li><a href="selltoseller"><i class="material-icons"><img src="src/icons/selltoseller.png" width="25" alt=""></i>Sell To Seller</a></li>
        <li><a href="credits"><i class="material-icons"><img src="src/icons/credits.png" width="25" alt=""></i>Credits</a></li>
        <li><a href="creditors"><i class="material-icons"><img src="src/icons/creditors.png" width="25" alt=""></i>Creditors</a></li>
        <li><a href="invoices"><i class="material-icons"><img src="src/icons/invoices.png" width="25" alt=""></i>Invoices</a></li>
        <li><a href="sellers"><i class="material-icons"><img src="src/icons/sellers.png" width="25" alt=""></i> All Sellers</a></li>
        <li><a href="addseller"><i class="material-icons"><img src="src/icons/addseller.png" width="25" alt=""></i> Add Seller</a></li>
        <li><a href="addproduct"><i class="material-icons"><img src="src/icons/add_product.png" width="25" alt=""></i> Add Product</a></li>
        <li><a href="addproductsinfo"><i class="material-icons"><img src="src/icons/info.png" width="25" alt=""></i> Add Products Info</a></li>
<!--         <li><a href="addbrand"><i class="material-icons"><img src="src/icons/brand.png" width="25" alt=""></i> Add Brand</a></li>
        <li><a href="addsize"><i class="material-icons"><img src="src/icons/size.png" width="25" alt=""></i> Add Size</a></li>
        <li><a href="addcategory"><i class="material-icons"><img src="src/icons/category.png" width="25" alt=""></i> Add Category</a></li>
        <li><a href="addlocation"><i class="material-icons"><img src="src/icons/location.png" width="25" alt=""></i> Add Location</a></li> -->
        <div class="divider"></div>
        <li><a href="include/logout.php"><i class="material-icons">power_settings_new</i>Logout</a></li>
        <li><a href="#!"><i class="material-icons"><img src="src/icons/about.png" width="25" alt=""></i>About Us</a></li>
        <li><a href="#!"><i class="material-icons"><img src="src/icons/contact.png" width="25" alt=""></i>Contact Us</a></li>
</ul>