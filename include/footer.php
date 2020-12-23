</body>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/toast.js"></script>
<script src="js/alert.js"></script>
<script src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<!-- ----------------------------- -->

<script type="text/javascript">
    // let BASE_URL = 'http://socialcodia.net/azmiunanistore/public/';

    let pathname = document.location.pathname;
    let endPathname = pathname.substring(pathname.lastIndexOf('/') + 1);

  function closeModal(){
    $('#modal1').modal('close');
  }

  function openModal(){
    $('#modal1').modal('open');
  }
  let token = getToken();
  $(document).ready(function ()
  {
    $('.modal').modal();
    $('.tooltipped').tooltip();
    $('.collapsible').collapsible();
    $('.sidenav').sidenav();
    $('select').formSelect();
    changePageName();
    if (endPathname=='addproduct') 
    {
      getBrands();
      getSizes();
      getCategories();
      getLocations();
    }
  });

function playSuccess()
{
  let audio = new Audio('src/aud/success.ogg');
  audio.play();
}

function playError()
{
  let audio = new Audio('src/aud/error.ogg');
  audio.play();
}


function playWarning()
{
  let audio = new Audio('src/aud/warning.ogg');
  audio.play();
}

function getToken() {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; token=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

function changePageName()
{
  let location = window.location.pathname;
  let pathname = location.substring(location.lastIndexOf('/') + 1);
  let pageName = document.getElementById('pageName');

  switch(pathname)
  {
    case 'dashboard':
      pageName.innerHTML = 'Dashboard';
      break;
    case 'sell':
    pageName.innerHTML = 'Sell Product';
    break;
    case 'products':
      pageName.innerHTML = 'All Products';
      break;
    case 'addproduct':
      pageName.innerHTML = 'Add Product';
      break;
    case 'expiringproducts':
      pageName.innerHTML = 'Expiring Products';
      break;
    case 'productsnotice':
      pageName.innerHTML = 'Products Notice';
      break;
    case 'expiredproducts':
      pageName.innerHTML = 'Expired Products';
      break;
    case 'productsrecord':
      pageName.innerHTML = 'Products Record';
      break;
    case 'addproductsinfo':
    pageName.innerHTML = 'Add Products Information';
    break;
    case 'salestoday':
      pageName.innerHTML = 'Todays Sale';
      break;
    case 'salesall':
      pageName.innerHTML = 'All Sales';
      break;
    default:
      pageName.innerHTML = 'Azmi Unani Store';
      break;
    
  }
}

function openModalTextController()
{
  let inputOpenModal = document.getElementById('inputOpenModal');
  let inputModal = document.getElementById('productName');
  inputModal.value = inputOpenModal.value;
  inputModal.focus();
  inputOpenModal.value = null;
  openModal();
  filterProduct();

}

    // let thSr = document.getElementById('thSr');
    // let thName = document.getElementById('thName');
    // let thSize = document.getElementById('thSize');
    // let thPrice = document.getElementById('thPrice');
    // let thSellPrice = document.getElementById('thSellPrice');
    // let thQuatntity = document.getElementById('thQuatntity');
    // let thBrand = document.getElementById('thBrand');
    let productTable = document.getElementById('productTable');
    let tableBody = document.getElementById('tableBody');


//       var table = $('#example').DataTable({
//         ajax: 'http://socialcodia.net/azmiunanistore/public/demos',
//         "paging":   false,
//         "ordering": false,
//         "info":     false,
//         keys: {
//            keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */ ]
//         }
//     });
    
//     // Handle event when cell gains focus
//     $('#example').on('key-focus.dt', function(e, datatable, cell){
//         // Select highlighted row
//         $(table.row(cell.index().row).node()).addClass('selected');
//     });

//     // Handle event when cell looses focus
//     $('#example').on('key-blur.dt', function(e, datatable, cell){
//         // Deselect highlighted row
//         $(table.row(cell.index().row).node()).removeClass('selected');
//     });
        
//     // Handle key event that hasn't been handled by KeyTable
//     $('#example').on('key.dt', function(e, datatable, key, cell, originalEvent){
//         // If ENTER key is pressed
//         if(key === 13){
//             // Get highlighted row data
//             var data = table.row(cell.index().row).data();
//             console.log(data[0]);
//             // FOR DEMONSTRATION ONLY
//             $("#example-console").html(data.join(', '));
//             closeModal();
//             var row = tableBody.insertRow(0);
//             row.innerHTML = '<tr><td>'+data[0]+'</td><td>'+data[1]+'</td><td>'+data[2]+'</td><td>'+data[3]+'</td><td>'+data[4]+'</td><td>'+data[5]+'</td><td>'+data[6]+'</td></tr>';
//             console.log(tableBody);
//         }
//     });       
// });
</script>

<!-- ----------------------------- -->
  <script>
    //$(document).ready(function(){
    // $('.tooltipped').tooltip();
    // $('.collapsible').collapsible();
    // $('.sidenav').sidenav();
    // $('select').formSelect();
    // getBrands();
    // getSizes();
    // getCategories();
    // getLocations();
// getProducts();
 // });
  </script>


  <script type="text/javascript">

    if (endPathname=='sell')
    {
        (function() {
      var trows = document.getElementById('mstrTable').rows, t = trows.length, trow, nextrow,
      // rownum = document.getElementById('rownum'),
      addEvent = (function(){return window.addEventListener? function(el, ev, f){
              el.addEventListener(ev, f, false); //modern browsers
          }:window.attachEvent? function(el, ev, f){
              el.attachEvent('on' + ev, function(e){f.apply(el, [e]);}); //IE 8 and less
          }:function(){return;}; //a very old browser (IE 4 or less, or Mozilla, others, before Netscape 6), so let's skip those
      })();

      function option(num){
        // console.log(num);
          // var o = document.createElement('option');
          // o.value = num;
          // rownum.insertBefore(o, rownum.options[1]); //IE 8 and less, must insert to page before setting text property
          let o = trows[num].cells[0].innerHTML + ' (' + num + ')';
          return o;
      }

      // function rownumchange(){
      //     if(this.value > 0){ //activates the highlight function for the selected row (highlights it)
      //         highlightRow.apply(trows[this.value]);
      //     } else { //activates the highlight function for the row that is currently highlighted (turns it off)
      //         highlightRow.apply(trows[highlightRow(true)]);
      //     }
      //     this.blur(); //prevent Mozilla from firing on internal events that change rownum's value
      // }

      // addEvent(rownum, 'change', rownumchange);

      // rownum.value = 0; //reset for browsers that remember select values on reload

      while (--t > 0) {
          trow = trows[t];
          trow.className = 'normal';
          addEvent(trow, 'click', highlightRow);
          option(t);
      }//end while

      function highlightRow(gethighlight) { //now dual use - either set or get the highlighted row
          gethighlight = gethighlight === true;
          var t = trows.length;
          while (--t > 0) {
              trow = trows[t];
              if(gethighlight && trow.className === 'highlighted'){return t;}
              else if (!gethighlight){
                  if(trow !== this) { trow.className = 'normal'; }
                  // else if(this.className === 'normal') { rownum.value = t; }
                  // else { rownum.value = 0; }
              }
          }//end while

          return gethighlight? null : this.className = this.className === 'highlighted'? 'normal' : 'highlighted';
      }//end function

      function movehighlight(way, e){
          e.preventDefault && e.preventDefault();
          e.returnValue = false;
          var idx = highlightRow(true); //gets current index or null if none highlighted
          // console.log(idx);
          if(typeof idx === 'number'){//there was a highlighted row
              idx += way; //increment\decrement the index value
              if(idx && (nextrow = trows[idx])){ return highlightRow.apply(nextrow); } //index is > 0 and a row exists at that index
              else if(idx){ return highlightRow.apply(trows[1]); } //index is out of range high, go to first row
              return highlightRow.apply(trows[trows.length - 1]); //index is out of range low, go to last row
          }
          return highlightRow.apply(trows[way > 0? 1 : trows.length - 1]); //none was highlighted - go to 1st if down arrow, last if up arrow
      }//end function

      function processkey(e){
          switch(e.keyCode){
              case 38: {//up arrow
                  return movehighlight(-1, e);
              }
              case 40: {//down arrow
                  return movehighlight(1, e);
              }
              case 13: {//down arrow
                   let o = highlightRow(true);
                   console.log(trows[o].childNodes[1].id);
                   let pid = trows[o].childNodes[1].id;

                   sellProduct(pid);
                   closeModal();
                   // $("td",trow).each(function(){
                   //  //access the value as
                   //   console.log($(this).html());
                   //  });
              }
              default: {
                  return true;
              }
          }
      }//end function

      addEvent(document, 'keydown', processkey);
      addEvent(window, 'unload', function(){}); //optional, resets the page for browsers that remember the script state on back and forward buttons

  }/* end function */)();//execute function and end script
    }

  </script>


  <script type="text/javascript">

    let BASE_URL = 'http://socialcodia.net/azmiunanistore/public/';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

    // document.addEventListener("DOMContentLoaded", getCategories());

    function filterProduct() {
      var input, filter, table, tr, td, cell, i, j;
      input = document.getElementById("productName");
      filter = input.value.toUpperCase();
      table = document.getElementById("mstrTable");
      tr = table.getElementsByTagName("tr");
      for (i = 1; i < tr.length; i++) {
        // Hide the row initially.
        tr[i].style.display = "none";
      
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
          cell = tr[i].getElementsByTagName("td")[j];
          if (cell) {
            if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
              break;
            } 
          }
        }
      }
    }

    function addProduct()
    {
      let selectBrand = document.getElementById('selectBrand');
      let selectCategory = document.getElementById('selectCategory');
      let selectSize = document.getElementById('selectSize');
      let manMonth = document.getElementById('manMonth');
      let manYear = document.getElementById('manYear');
      let expMonth = document.getElementById('expMonth');
      let expYear = document.getElementById('expYear');
      let productName = document.getElementById('productName');
      let productPrice = document.getElementById('productPrice');
      let productQuantity = document.getElementById('productQuantity');
      let btnAddProduct = document.getElementById('btnAddProduct');
      
      if (selectBrand.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Brand"
        });
        return;
      }
      if (selectCategory.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Category"
        });
        return;
      }
      if (selectSize.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Size"
        });
        return;
      }
      if (selectLocation.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select location"
        });
        return;
      }
      if (productName.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Product"
        });
        return;
      }
      if (productName.value.length<4)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "product Name too short"
        });
        return;
      }
      if (productPrice.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Price"
        });
        return;
      }
      if (productPrice.value<10)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "price too short"
        });
        return;
      }
      if (productQuantity.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Quantity"
        });
        return;
      }
      if (productQuantity.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "product Quantity too short"
        });
        return;
      }
      if (manMonth.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Manufacture Month"
        });
        return;
      }
      if (manYear.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Manufacture Year"
        });
        return;
      }
      if (expMonth.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Expire Month"
        });
        return;
      }
      if (expYear.value<1)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Select Expire Year"
        });
        return;
      }
      let productManufactureDate = manYear.value+'-'+manMonth.value+'-01';
      let productExpireDate = expYear.value+'-'+expMonth.value+'-01';
      let a = new Date(productManufactureDate);
      let b = new Date(productExpireDate);
      if (a>b)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "The Manufacture date could not be greater than expire date"
        });
        return;
      }
      btnAddProduct.classList.add('disabled');
      
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"add/product",
        data: 
        {  
           'productName' : productName.value,
           'productBrand':selectBrand.value,
           'productCategory':selectCategory.value,
           'productSize':selectSize.value,
           'productLocation':selectLocation.value,
           'productPrice':productPrice.value,
           'productQuantity':productQuantity.value,
           'productManufactureDate':productManufactureDate,
           'productExpireDate':productExpireDate
        },
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            playSuccess();
            console.log(response);
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            btnAddProduct.classList.remove('disabled');
          }
          else
          {
            playWarning();
            productName.value = '';
            productPrice.value = '';
            productQuantity.value = '';
            // manMonth.selectedIndex = 0;
            // manYear.selectedIndex = 0;
            // expMonth.selectedIndex = 0;
            // expYear.selectedIndex = 0;
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnAddProduct.classList.remove('disabled');
          }
        }
      });
    }

    function deleteSoldProduct(value)
    {
      let btnDelete = document.getElementById('btnDelete'+value);
      let row = document.getElementById('rowId'+value);
      btnDelete.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"product/sell/delete",
        data: 
        {  
           'sellId' : value
        },
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            playSuccess();
            row.remove();
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            btnDelete.classList.remove('disabled');
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnDelete.classList.remove('disabled');
          }
        }
      });
    }

    function alertDeleteSaleProduct(value)
    {
          Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure want to delete this sale entry',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Delete Entry'
          }).then((result) => {
          if (result.isConfirmed) 
          {
            deleteSoldProduct(value);
          }
          });
    }

    function addBrand()
    {
      let brandName = document.getElementById('brandName');
      let btnAddBrand = document.getElementById('btnAddBrand');
      if (brandName.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Brand Name"
        });
        return;
      }
      if (brandName.value.length<3)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Brand Name too short"
        });
        return;
      }
      btnAddBrand.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"add/brand",
        data: 
        {  
           'brandName' : brandName.value
        },
        success:function(response)
        {
          if (!response.error)
          {
            playSuccess();
            brandName.value = '';
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            btnAddBrand.classList.remove('disabled');
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnAddBrand.classList.remove('disabled');
          }
        }
      });
    }

    let count = 1;
    function sellProduct(value)
    {
      // let brandName = document.getElementById('brandName');
      let SellRecordTableBody = document.getElementById('SellRecordTableBody');
        if (value=='')
        {
            playError();
            Toast.fire({
                      icon: 'error',
                      title: "Failed To Fetch Product Id"
            });
            return;
        }
        
      // btnAddBrand.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"product/sell",
        data: 
        {  
           'productId' : value
        },
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            playSuccess();
            let product = response.product;
            let tr = document.createElement('tr');
            tr.id = 'rowId'+product.saleId;
            let tdSr = '<td>'+count+'</td>';
            let tdSId = '<td class="hide"><input type="text" id="saleId'+product.saleId+'" value="'+product.saleId+'" readonly="readonly"></td>';
            let tdPName = '<td id="productName'+product.saleId+'">'+product.productName+'</td>';
            let tdPSize = '<td>'+product.productSize+'</td>';
            let tdPPrice = '<td id="productPrice'+product.saleId+'">'+product.productPrice+'</td>';
            let tdPQuantity = '<td><input class="center" type="number" onkeyup="changePrice(this.value)" style="width:40px;" id="productQuantity'+product.saleId+'" value="1"></td>';
            let tdAPQuantity = '<td class="hide" id="productAllQuantity'+product.saleId+'">'+product.productQuantity+'</td>';
            let tdPTPrice = '<td Id="productTotalPrice'+product.saleId+'">'+product.productPrice+'</td>';
            let tdPSellPrice = '<td><input type="number" onkeyup="priceEvent(this.value)" style="width:60px;" id="productSellPrice'+product.saleId+'" value="'+product.productPrice+'"></td>';
            let tdPBrand = '<td>'+product.productBrand+'</td>';
            let tdPAction = '<td><button style="border: 1px solid white;border-radius: 50%; display:none" onclick="updateSellRecord(this.value)" value="'+product.saleId+'" id="btnUpdate'+product.saleId+'" class="btn blue"><i class="material-icons white-text large">check_circle</i></button><button id="btnDelete'+product.saleId+'" value="'+product.saleId+'" onclick="alertDeleteSaleProduct(this.value)" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">delete_forever</i></button></td>';
            tr.innerHTML=tdSr+tdSId+tdPName+tdPSize+tdPPrice+tdPQuantity+tdAPQuantity+tdPTPrice+tdPSellPrice+tdPBrand+tdPAction;
            SellRecordTableBody.appendChild(tr);
            // Toast.fire({
            //       icon: 'success',
            //       title: response.message
            //   });
            // btnAddBrand.classList.remove('disabled');
            count++;
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            // btnAddBrand.classList.remove('disabled');
          }
        }
      });
    }

    function updateSellRecord(value)
    {
      let btnUpdate =  document.getElementById('btnUpdate'+value);
      let productQuantity =  document.getElementById('productQuantity'+value);
      let productAllQuantity = document.getElementById('productAllQuantity'+value);
      let productSellPrice =  document.getElementById('productSellPrice'+value);
      let productName = document.getElementById('productName'+value);
      let quantity = productQuantity.value;
      let price = productSellPrice.value;
      if (quantity<1)
      {
        playWarning();
        Toast.fire({
            icon: 'error',
            title: 'Product Quantity Is Low'
        });
        return;
      }
      btnUpdate.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"product/sell/update",
        data:{
          'saleId':value,
          'productQuantity':quantity,
          'productSellPrice':price
        },
        success:function(response)
        {
          btnUpdate.classList.remove('disabled');
          console.log(response);
          if (!response.error)
          {
            btnUpdate.style.display = 'none';
            playSuccess(); 
            Toast.fire({
              icon: 'success',
              title: response.message
            });
          }
          else
          {
            playError();
            if (new String(response.message).valueOf() == new String("Product Not Available").valueOf())
            {
              let productAC = parseInt(productAllQuantity.innerText)+1;
                let text = "<b>The Available Quantity Of <span class='blue-text'>"+productName.innerText+"</span> Is <h4 style='font-weight:bold; color:red'>"+productAC+"</h4>Please Decrease The Quantity.</b>";
                Swal.fire({
                icon: 'warning',
                title: response.message,
                html: text
              });
            }
            else
            {
              playWarning();
              Toast.fire({
                icon: 'error',
                title: response.message
              });
            }
          }
        }
      });
    }

    function changePrice(quantity)
    {
      quantity = parseInt(quantity);
      let sellId = $(event.target)[0].id.replace('productQuantity','');
      let productTotalPrice = document.getElementById('productTotalPrice'+sellId);
      let productPrice = document.getElementById('productPrice'+sellId);
      let productSellPrice = document.getElementById('productSellPrice'+sellId);
      let productQuantity = document.getElementById('productQuantity'+sellId);
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      btnUpdateProduct.style.display = 'block';
      if(quantity<1)
      {
        productQuantity.value = 1;
        quantity = 1;
      }
      let price = parseInt(productPrice.innerText);
      let fPrice = price*quantity;
      productTotalPrice.innerHTML = fPrice;
      productSellPrice.value = fPrice;
    }

    function priceEvent(value)
    {
      let sellId = $(event.target)[0].id.replace('productSellPrice','');
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      btnUpdateProduct.style.display = 'block';
    }

    function getBrands()
    {
      $.ajax({
        headers:{  
           'token':token
        },
        type:"get",
        url:BASE_URL+"get/brands",
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            let brands = response.brands;
            brands.forEach(setCategory);
            function setCategory(item, index) {
              $('#selectBrand').formSelect().append($('<option value="'+item.brandId+'">'+item.brandName+'</option>'));
              $('select').formSelect();
            }
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    }

    function getSizes()
    {
      $.ajax({
        headers:{  
           'token':token
        },
        type:"get",
        url:BASE_URL+"get/sizes",
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            let sizes = response.sizes;
            sizes.forEach(setCategory);
            function setCategory(item, index) {
              $('#selectSize').formSelect().append($('<option value="'+item.sizeId+'">'+item.sizeName+'</option>'));
              $('select').formSelect();
            }
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    }

    function getCategories()
    {
      let select = document.getElementById('selectCategory');

      $.ajax({
        headers:{  
           'token':token
        },
        type:"get",
        url:BASE_URL+"get/categories",
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            let categories = response.categories;
            categories.forEach(setCategory);
            function setCategory(item, index) {
              $('#selectCategory').formSelect().append($('<option value="'+item.categoryId+'">'+item.categoryName+'</option>'));
              $('select').formSelect();
            }
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    }

    function getLocations()
    {
      $.ajax({
        headers:{  
           'token':token
        },
        type:"get",
        url:BASE_URL+"get/locations",
        success:function(response)
        {
          console.log(response);
          if (!response.error)
          {
            let locations = response.locations;
            locations.forEach(setCategory);
            function setCategory(item, index) {
              $('#selectLocation').formSelect().append($('<option value="'+item.locationId+'">'+item.locationName+'</option>'));
              $('select').formSelect();
            }
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    }

    let mProducts;

    function getProducts()
    {
      let select = document.getElementById('selectLocation');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"get",
        url:BASE_URL+"get/products",
        success:function(response)
        {
          console.log(response);
          if(!response.error)
          {
            products = response.products;
            console.log(products);
          $('#productTable').DataTable( {
              data: response
          } );
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      });
    }

    function sendItem(value)
    {
      
    }

    function addSize()
    {
      let sizeName = document.getElementById('sizeName');
      let btnAddSize = document.getElementById('btnAddSize');
      if (sizeName.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Size Name"
        });
        return;
      }
      if (sizeName.value.length<4)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Size Name too short"
        });
        return;
      }
      btnAddSize.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"add/size",
        data: 
        {  
           'sizeName' : sizeName.value
        },
        success:function(response)
        {
          if (!response.error)
          {
            playSuccess();
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            sizeName.value = '';
            btnAddSize.classList.remove('disabled');
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnAddSize.classList.remove('disabled');
          }
        }
      });
    }

    function addCategory()
    {
      let categoryName = document.getElementById('categoryName');
      let btnAddCategory = document.getElementById('btnAddCategory');
      if (categoryName.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Category Name"
        });
        return;
      }
      if (categoryName.value.length<4)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Category Name too short"
        });
        return;
      }
      btnAddCategory.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"add/category",
        data: 
        {  
           'categoryName' : categoryName.value
        },
        success:function(response)
        {
          if (!response.error)
          {
            playSuccess();
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            categoryName.value = '';
            btnAddCategory.classList.remove('disabled');
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnAddCategory.classList.remove('disabled');
          }
        }
      });
    }

    function addLocation()
    {
      let locationName = document.getElementById('locationName');
      let btnAddLocation = document.getElementById('btnAddLocation');
      if (locationName.value=='')
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Enter Location Name"
        });
        return;
      }
      if (locationName.value.length<2)
      {
        playWarning();
        Toast.fire({
                  icon: 'error',
                  title: "Location Name too short"
        });
        return;
      }
      btnAddLocation.classList.add('disabled');
      $.ajax({
        headers:{  
           'token':token
        },
        type:"post",
        url:BASE_URL+"add/location",
        data: 
        {  
           'locationName' : locationName.value
        },
        success:function(response)
        {
          if (!response.error)
          {
            playSuccess();
            Toast.fire({
                  icon: 'success',
                  title: response.message
              });
            locationName.value = '';
            btnAddLocation.classList.remove('disabled');
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            btnAddLocation.classList.remove('disabled');
          }
        }
      });
    }
  </script>

  
</html>