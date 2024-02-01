<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
 
  <a href="./dashboard.php">  <i class="fa fa-dashboard fa-fw">
                </i> Dashboard</a>
  <a  href="./insert-product.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Prodcuts</a>
  <a href="./all-Products.php"><i class="fa fa-list-ol" aria-hidden="true"></i> All Products</a>
  <a href="./allorder.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i> All Orders</a>
  <a  href="./product_stock.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Stock</a>


 <a href="./allcategories.php"><i class="fa fa-tags" aria-hidden="true"></i> All Categories</a>

 <a href="./productctg.php"> <i class="fa fa-picture-o" aria-hidden="true"></i> Product Categories</a>
 <a href="./slider.php">  <i class="fa fa-rss" aria-hidden="true"></i></i> Slider</a>


 <a href="../index.php"><i class="fa fa-home" aria-hidden="true"></i> 
 Home</a>
</div>


  <button class="openbtn" onclick="openNav()">☰ </button>  


<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>