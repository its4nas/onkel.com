<?php
session_start();
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['role_id']==2)
{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>users page</title>
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
<?php
    require('dbconnect.php');
    include('admin_nav.php');
?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12" style="margin-top:45px;">
                <h2><i class="bi bi-chat-dots" ></i> Comments</h2>


            </div>
        </div>
        <!-- /. ROW  -->

        <div class="row">
            <div class="col-md-8">
                
            </div>

        </div>


        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                  
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <th>Emial</th>
                                    <th>Comment</th>
                                </thead>
                                <tbody>
                                <?php
                        $sql = "select * from comments";
                        $stm = $con->prepare($sql);
                        $stm -> execute();

                        if($stm->rowCount())
                        {
                          foreach($stm-> fetchAll() as $row)
                          { 
                          
                      ?>
                      <tr>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                        
                      </tr>
                      <?php  }
                        }  ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->

            </div>
            <!-- /. ROW  -->
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
</div>
<?php
include("footer.php");
}
else
{
  header("location:login.php");
}
?>


<!-- -----------------------------------------------------------------------
-----------------------------------------------------------------------
-----------------------------------------------------------------------

<div class="container mt-5">

    <div class="row  d-flex justify-content-center">

        <div class="col-md-8">

            <div class="headings d-flex justify-content-between align-items-center mb-3">
                <h5> Comments</h5>                        
            </div>

            <div class="card p-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="user d-flex flex-row align-items-center">

                        <span><small class="font-weight-bold text-primary">james_olesenn</small> <small class="font-weight-bold">Hmm, This poster looks cool</small></span>
                        
                    </div>

                    <small>2 days ago</small>

                </div>

                <div class="icons align-items-center">

                    <i class="fa fa-star text-warning"></i>
                    <i class="fa fa-check-circle-o check-icon"></i>
                    
                </div>
            </div>    
                    
      
         </div>
                
    </div>
            
</div> -->