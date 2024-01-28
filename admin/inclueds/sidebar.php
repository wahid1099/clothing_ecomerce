<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
 
  <a href="./dashboard.php">  <i class="fa fa-dashboard fa-fw">
                </i> Dashboard</a>
  <a  href="./insert-product.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Prodcuts</a>
  <a href="./all-Products.php"><i class="fa fa-list-ol" aria-hidden="true"></i>
 All Products</a>
  <a href="./allorder.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
 All Ordres</a>
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