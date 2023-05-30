<?php
session_start();
if(isset($_SESSION['user_info']))
{
?>
<?php require("header.php");
      require_once("dbconnect.php"); ?>
<div style="background:#dcdcdc;">
<?php
// Code for displaying the table
if(isset($_GET['action'],$_GET['id']) && $_GET['action']=='prodview') 
{
$cat_id = $_GET['id'];
$sql3=$con->prepare("SELECT * FROM products WHERE category_id =:catid");
$sql3->execute(array("catid"=>$cat_id));

$sql4=$con->prepare("SELECT * FROM categories WHERE category_id =:catid");
$sql4->execute(array("catid"=>$cat_id));

?>
<br>
<div style="text-align: center;">
    <h3>List of <?php foreach($sql4 as $row){ echo $row['category_name']; } ?></h3>
</div>
<div class="Cards">


  <div class="CARDcontainer">
      
        <?php foreach($sql3 as $row ) 
        { ?> 

            <div class="card">
                
                <div class="imgbx">
                    <img src="images/upload/<?php echo $row['img_url'];?>">
                <ul class="action">
                        <li> 
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <span>Add to Wishlist</span>
                        </li>

                        <li> 
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span>Add to Cart</span>
                        </li>

                        <li> 
                        <a href="product.php?action=product&id=<?php echo $row['product_id'] ?>&cid=<?php echo $row['category_id'] ?>" style="text-decoration: none; text-decoration-style:none;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <span>View Details</span>
                        </li>
                    </ul>
                </div>

                <div class="content">
                    <div class="productname">
                        <a href="prodview"><h3 style="font-size: 22px;"><?php echo $row['name'];?></h3></a>
                    </div>

                    <div class="priceRating" style="text-align: center;">
                        <h2 style="font-size: 18px;"><?php echo $row['price'];?>$</h2>
                    <!-- <div class="rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa grey fa-star" aria-hidden="true"></i>
                            
                        </div> -->
                    </div>
                </div>
              </div>
            


<?php   }?>






      

    </div>


</div>

<?php } ?>


</div>
<?php
}
else
{
  header("location:login.php");
}
?>
<?php require("footer.php"); ?>