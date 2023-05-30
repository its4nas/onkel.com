<?php
session_start();
if(isset($_SESSION['user_info']))
{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>products page</title>
    
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/card.css?version=1" />
</head>

<body>

<?php
    require('dbconnect.php');
    include('admin_nav.php');
?>

    
        
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-10">
                        <h2><i class="fa fa-tasks" style="margin-top:25px;"></i> Products</h2>


                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New product
                            </div>

                            <?php
                            function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                
                                return $data;
                              }

                                if(isset($_POST['add_product']))
                                {
                                    $file= $_FILES['image'];
                                    $name = test_input($_POST['name']);
                                    $price = $_POST['price'];
                                    $count = $_POST['count'];
                                    $description =test_input($_POST['description']);
                                    $category_name = $_POST['categories'];
                                    

                                    $errors = array();

                                    if(is_numeric($name))
                                    {
                                        $errors['name'] = "Name must be string";
                                    }
                                    if($_FILES['image']['error'] === 4)
                                    {
                                        echo "<br> image does not exits";
                                    }
                                    else
                                    {
                                        $file_name = $file['name'];
                                        $file_size = $file['size'];
                                        $temp_name = $file['tmp_name'];

                                        $validImgExtension=array('jpg','gif','png');
                                        $imgExtension=explode('.',$file_name);
                                        $imgExtension=strtolower(end($imgExtension));
                                        if(!in_array($imgExtension, $validImgExtension))
                                        {
                                            echo "<br> Invalid file type";
                                        }
                                        else if($file_size > 10000000)
                                        {
                                            echo "<br> file too large";
                                        }
                                        
                                        else 
                                        {
                                        $new_img_name = uniqid();
                                        $new_img_name .='.'.$imgExtension;

                                        move_uploaded_file($temp_name, 'images/upload/'.$new_img_name);
                                        
                                    if(empty($errors))
                                    {
                                        $sql = "insert into products (name, category_id, img_url, price, count ,description) VALUES ( ? , ?, ?,?,? ,?)";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($name, $category_name, $new_img_name, $price, $count,$description));

                                        if($stm->rowCount())
                                        {
                                            echo "<script>
                                            alert('One Row Inserted');
                                            window.open('admin_products.php','_self');
                                            </script>";

                                        }
                                        else
                                        {
                                            echo "<div class='alert alert-danger' >Row not Inserted </div>";
                                            
                                        }
                                    }
                                }
                            }
                        }
                                
                            ?>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" placeholder="Please Enter your Name " required
                                                    class="form-control" />
                                                    <i style="color:red;"><?php
                                                        if(isset($errors['name']))
                                                        echo $errors['name'];
                                                    ?></i>
                                            </div>
                                            <!-- photo here -->
                                            <br>
                                            <label>Photo</label><br>
                                            <input type="file" name="image" class="form-control" >
                                            <br>
                                            <div class="form-group">
                                                <label>category</label><br>
                                                <select class="form-control" name="categories" >
                                        <?php
                                            $sql = "select * from categories";
                                            $stm = $con->prepare($sql);
                                            $stm -> execute();

                                            if($stm->rowCount())
                                            {
                                                foreach($stm->fetchAll() as $row)
                                                {
                                                ?>
                                               <option value=<?php echo $row['category_id'] ?>> <?php echo $row['category_name']  ?></option>
                                            <?php
                                                }
                                            }
                                            ?>                                      
                                            
                                            
                                        </select>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <label>Price</label><br>
                                                <input type="text" name="price" class="form-control" placeholder="Please Enter the price " required>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <label>Count</label><br>
                                                <input type="text" name="count" class="form-control" placeholder="Please Enter the count of the product " required>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <br>
                                                <label>Description</label>
                                                <textarea placeholder="Please Enter Description" required name="description" class="form-control"
                                                    cols="30" rows="3"></textarea>
                                            </div>
                                                <br>
                                            <div style="float:right;">
                                                <button type="submit" name="add_product" class="btn btn-primary">Add Category</button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>

                                    </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tasks"></i> Products
                            </div>
                            <?php
                                if(isset($_GET['action'],$_GET['id']))
                                {
                                    $id = $_GET['id'];
                                    switch($_GET['action'])
                                    {
                                        case "delete":
                                        $sql = "delete from products where product_id=$id";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute();
                                        if($stm->rowCount()==1)
                                        {
                                            echo "<div class='alert alert-success'>One Row Deleted</div>";
                                            
                                            
                                        }
                                        break;

                                        default :echo "Error";break;
                                    }
                                }
                            ?>
                            <div class="panel-body">
                            <div class="Cards">
    <div class="CARDcontainer">
    <?php
    $sql = "select * from products";
    $stm = $con->prepare($sql);
    $stm -> execute();

    ?>

    <?php
    if($stm->rowCount())
    {
        foreach($stm->fetchAll() as $row)
        {
            $id = $row['product_id'];
            $product_name = $row['name'];
            $description = $row['description'];
            $image = $row['img_url'];
            $price = $row['price'];
            $count = $row['count'];

        ?>
        
    

    
        <div class="card">
            
            <div class="imgbx">
                <img src="images/upload/<?php echo $image; ?>">
            </div>

            <div class="content">
                <div class="productname">
                    <h3><?php echo $product_name; ?></h3>
                </div>

                <div class="productname">
                    <h3><?php echo " Price: $". $price; ?></h3>
                </div>

                <div class="productname">
                    <h3><?php echo "Quantity: " . $count; ?></h3>
                </div>

                <div >
                    <p><?php echo $description; ?></p>
                </div>
                <a href="admin_edit_product.php?action=edit&id=<?php echo $id  ?>" class='btn btn-primary'>Edit</a>
                <a href="?action=delete&id=<?php echo $id  ?>" class='btn btn-danger' id="delete" onclick="return confirm('Are You Sure?');">Delete</a>
                                                    
            </div>
        </div>
       
                
        

        <?php
        }
    }
    ?>
    </div>
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

    

    
   
<!-- <script>
        $('#delete').click(function()
        {
            return confirm('Are You Sure!!');
        });
    </script> -->

    <?php
}
else
{
  header("location:login.php");
}
?>

</body>

</html>