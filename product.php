<?php 
session_start();
if(isset($_SESSION['user_info']))
{
require_once("dbconnect.php");
   include("header.php");  ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
<!-- <script src="js/product.js" charset="utf-8"></script> -->
<?php
if(isset($_GET['action'],$_GET['id'],$_GET['cid']) && $_GET['action']=='product') 
{
$products_id = $_GET['id'];
$sql3=$con->prepare("SELECT * FROM products WHERE product_id =:prodid");
$sql3->execute(array("prodid"=>$products_id));

 $cat_id = $_GET['cid'];
$sql4=$con->prepare("SELECT * FROM categories WHERE category_id =:catid");
$sql4->execute(array("catid"=>$cat_id));
 
foreach($sql4 as $data1){  $tag = $data1['category_name']; }

?>



<main class="PRODcontainer">
<?php foreach($sql3 as $row) { ?>

      <!-- Left Column / Headphones Image -->
      <div class="left-column">
        <!-- <img data-image="blue" src="images/blue.png" alt="">
             <img data-image="black" src="images/black.png" alt=""> -->
             <img data-image="red" class="active" src="images/upload/<?php echo $row['img_url'];?>" alt=""> 
      </div>


      <!-- Right Column -->
      <div class="right-column">

        <!-- Product Description -->
        <div class="product-description">
          <span><?php echo $tag ?></span>
          <h1><?php echo $row['name'] ?></h1>
          <p><?php echo $row['description'] ?></p>
        </div>
        <div>
            <h4>Stock: <?php echo $row['count'] ?> left.</h4>
        </div>

        <!-- Product Configuration -->
        <div class="product-configuration">

          <!-- Product Color -->
         <!-- <div class="product-color">
            <span>Color</span>

            <div class="color-choose">
              <div>
                <input data-image="red" type="radio" id="red" name="color" value="red" checked>
                <label for="red"><span></span></label>
              </div>
              <div>
                <input data-image="blue" type="radio" id="blue" name="color" value="blue">
                <label for="blue"><span></span></label>
              </div>
              <div>
                <input data-image="black" type="radio" id="black" name="color" value="black">
                <label for="black"><span></span></label>
              </div>
            </div>

          </div> -->

          <!-- Cable Configuration -->
          <div class="cable-config">
            <form method="POST">
            <span>Configuration</span>

            <div class="cable-choose">
              <button>White</button>
              <button>Black</button>
              <button>Blue</button>
            </div>

            <div class="form-outline">
              <label class="form-label" for="typeNumber">Quantity</label>  
              <input type="number" name="quantity" value=1 id="typeNumber" class="form-control" />
            </div><br>

            <!-- Product Pricing -->
            <div class="product-price">
              <span><strong><?php echo $row['price'] ?>$</strong></span>
             <button type="submit" name="buy" class="cart-btn">Add to cart</button>
            </div>

            <a href="#">How to configurate your items</a>
            </form>
          </div>
        </div>


        
      </div>
    </main>
     <?php } ?>
    <br><br>

<?php

  if(isset($_POST['buy']))
  {
    $pid= $row['product_id'];
    $price= $row['price'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_info']['id'];

    if(($row['count']-$quantity)>=0)
    {

      //$newQuantity = $data - 

      $sql2="INSERT INTO carts(product_id, price, quantity, user_id)
                       VALUES(?, ?, ?, ?)";
      $stm2=$con->prepare($sql2);
      //$stm2->execute(array($pid,$price,$quantity,$user_id));
      if($stm2->execute(array($pid,$price,$quantity,$user_id)))
      {

      $sql4="UPDATE products set count=(count - ?) WHERE product_id = ?";
      $stm4=$con->prepare($sql4);
      $stm4->execute(array($quantity, $pid));

      if($stm4->rowCount())
      {
        echo "<div class='alert alert-success' >Row Inserted </div>";

      }
      else
      {
        echo "<div class='alert alert-danger' >Row not Inserted </div>";
        
      }
      }
     else
      {
      echo "<div class='alert alert-danger' >Product is already in your cart.</div>";
      }
    }
    else
    {
      echo "<div class='alert alert-danger' >Invalid amount.</div>";
    }
  }

?>



    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <script src="script.js" charset="utf-8"></script>


    <?php
}
else
{
  header("location:login.php");
}
?>


<br><br><br><br><br><br>
<?php  } include("footer.php")  ?>