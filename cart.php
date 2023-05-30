
<?php
session_start();
if(isset($_SESSION['user_info']))
{
require('header.php');
require('dbconnect.php');

$sql = "SELECT c.cart_id, p.img_url, p.product_id, p.name, cat.category_name, c.quantity, p.price FROM carts c 
        LEFT JOIN products p ON c.product_id = p.product_id 
        INNER JOIN categories cat ON cat.category_id = p.category_id WHERE c.user_id = ?";
$stm = $con->prepare($sql);
$stm->execute(array($_SESSION['user_info']['id']));
$Total = 0;

if(isset($_GET['action'],$_GET['id']))
{
    $id = $_GET['id'];
    $pid = $_GET['pid'];
    $pquan = $_GET['pqn'];
    switch($_GET['action'])
    {
        case "delete":
        $sql = "delete from carts where cart_id=?";
        $stm = $con->prepare($sql);
        //$stm -> execute(array($id));
        if($stm -> execute(array($id)))
        {   
            $sql2 = "UPDATE products SET count=count+? WHERE product_id = ?";
            $stm2 = $con->prepare($sql2);
            $stm2 ->execute(array($pquan,$pid));
            if($stm2->rowCount()==1)
            {
                echo "<div class='alert alert-success'>Cart Item Deleted</div>";
            
            }   
        }
        break;



        default :echo "Error";break;
    }
}
?>






<section class="h-100" style="background-color: #eee;">
  <div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>
          <div>
            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i
                  class="fas fa-angle-down mt-1"></i></a></p>
          </div>
        </div>
        <?php foreach($stm->fetchAll() as $row) { ?>
        <div class="card rounded-3 mb-4">
          <div class="card-body p-4">
            <div class="row d-flex justify-content-between align-items-center">
              <div class="col-md-2 col-lg-2 col-xl-2">
                <img
                  src="images/upload/<?php echo $row['img_url']; ?>"
                  class="img-fluid rounded-3" alt=" ">
              </div>
              <div class="col-md-3 col-lg-3 col-xl-3">
                <p class="lead fw-normal mb-2"><?php echo $row['name']; ?></p>
                <p><span class="text-muted">Type: </span><?php echo $row['category_name']; ?></p>
              </div>
              <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
              <p><span class="text-muted">Quantity: </span><?php echo $row['quantity']; ?> <span class="text-muted"></span>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                <h5 class="mb-0">Price: <?php echo $row['quantity']*$row['price']; $Total += $row['quantity']*$row['price'];?>$
                </h5>
              </div>
              <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                <a href="?action=delete&id=<?php echo $row['cart_id']  ?>&pid=<?php echo $row['product_id'] ?>&pqn=<?php echo $row['quantity'] ?>" class="text-danger" title="Remove Item(s)."><i class="fas fa-trash fa-lg"></i></a>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>




        <!-- <div class="card mb-4">
          <div class="card-body p-4 d-flex flex-row">
            <div class="form-outline flex-fill">
              <input type="text" id="form1" class="form-control form-control-lg" />
              <label class="form-label" for="form1">Discound code</label>
            </div>
            <button type="button" class="btn btn-outline-warning btn-lg ms-3">Apply</button>
          </div>
        </div> -->
        
        <div class="card row d-flex justify-content-between align-items-center">
          <div class="card-body">
            <h3>Total: <em><?php echo $Total; ?>$</em></h3>
          </div>
        </div><br>

        <div class="card row d-flex justify-content-between align-items-center">
          <div class="card-body">
            <button type="button" name="pay" class="btn btn-primary btn-block btn-lg" onclick="return confirm('Are You Sure?');">Proceed to Buy</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>





<?php
}
else
{
  header("location:login.php");
}
?>



<?php require('footer.php'); ?>