<?php
session_start();
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['role_id']==2)
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin page</title>
  </head>
  <body>

    <?php
      require('dbconnect.php');
      include('admin_nav.php');
    ?>
    
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 text-primary">
            <h4>Dashboard</h4>
          </div>
        </div>
      
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card bg-white text-white h-100">
              <div class="card-body py-5"><b class="text-primary">
              
              <?php
                  
                $sql = "select * from visitors";
                $stm = $con->prepare($sql);
                $stm -> execute();

                echo $stm->rowCount();

              ?>
              
              Visitors</b></div>
              
              <div class="card-footer d-flex bg-primary">
                View Details
                <span class="ms-auto">
                  <i class="bi bi-chevron-right bg-primary"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-white text-white -100">
              <div class="card-body py-5"><b class="text-primary">$<?php
                $sql = "select * from carts";
                $stm = $con->prepare($sql);
                $stm -> execute();
                $total = 0;
                foreach($stm->fetchAll() as $row)
                {
                  $total += $row['price']*$row['quantity'];
                }
                echo $total;
              ?>    Earnings</b></div>
              
              <div class="card-footer d-flex bg-primary">
                View Details
                <span class="ms-auto">
                  <i class="bi bi-chevron-right bg-primary"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-white text-white h-100">
              <div class="card-body py-5"><b class="text-primary">
                
              <?php
                $sql = "select * from categories";
                $stm = $con->prepare($sql);
                $stm -> execute();

                echo $stm->rowCount();
              ?>
              
              Categories</b></div>
              
              <div class="card-footer d-flex bg-primary">
                View Details
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3 ">
            <div class="card text-white h-100">
              <div class="card-body py-5"><b class=" text-primary">
              
              <?php
                $sql = "select * from users";
                $stm = $con->prepare($sql);
                $stm -> execute();

                echo $stm->rowCount();
              ?>
              
              users</b></div>
              <div class="card-footer d-flex bg-primary" >
                View Details
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        
        
          


        <!-- <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Sales Table 
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="sales_table"
                    class="table table-striped data-table"
                    style="width: 100%"
                  >
                    <thead>
                      
                      <tr>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>quantity</th>
                        <th>Buy Date</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        // $sql = "select u.f_name, u.l_name, pr.name, p.quantity, p.buy_date, p.total_price
                        // from users u INNER JOIN payment p ON u.id = p.user_id
                        // INNER JOIN products pr ON pr.product_id = p.product_id";
                        // $stm = $con->prepare($sql);
                        // $stm -> execute();

                        // if($stm->rowCount())
                        // {
                        //   foreach($stm-> fetchAll() as $row)
                        //   {
                          
                      ?>
                      <tr>
                        <td><?php //echo $row['f_name']; echo " "; echo  $row['l_name']; ?></td>
                        <td><?php //echo $row['name']; ?></td>
                        <td><?php //echo $row['quantity']; ?></td>
                        <td><?php //echo $row['buy_date']; ?></td>
                        <td><?php //echo "$". $row['total_price']; ?></td>

                      </tr>
                      <?php  //}
                        //}  ?>

                      



                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Buy Date</th>
                        <th>amount</th>
                        <th>Price</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->


      <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Users Table 
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="sales_table"
                    class="table table-striped data-table"
                    style="width: 100%"
                  >
                    <thead>
                      
                      <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "select * from users";
                        $stm = $con->prepare($sql);
                        $stm -> execute();

                        if($stm->rowCount())
                        {
                          foreach($stm-> fetchAll() as $row)
                          { 
                          
                      ?>
                      <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['f_name']; echo " "; echo  $row['l_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php if($row['role_id'] == 1) {echo "customer";}
                        else {echo "admin";}?></td>

                      </tr>
                      <?php  }
                        }  ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>


    </main>

    
<?php
include("footer.php");
}
else
{
  header("location:login.php");
}
?>
