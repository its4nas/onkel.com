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
    <title>Category page</title>
    
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
                        <h2><i class="fa fa-tasks" style="margin-top:25px;"></i> Categories</h2>


                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New Category
                            </div>

                            <?php
                            function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                
                                return $data;
                              }

                                if(isset($_POST['add_category']))
                                {
                                    $file= $_FILES['image'];
                                    $name = test_input($_POST['name']);
                                    $description =test_input($_POST['description']);
                                    

                                    $errors = array();

                                    if(is_numeric($name))
                                    {
                                        $errors['name'] = "Name must be string";
                                    }
                                    if($_FILES['image']['error'] === 4)
                                    {
                                        echo "<br> image does not exits";
                                    }
                                    if(empty($name) || empty($description) )
                                    {
                                      $errors['empty'] = "all inputs are requried";
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
                                        $sql = "insert into categories (category_name, img_url, description) VALUES ( ? , ?, ? )";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($name, $new_img_name, $description));

                                        if($stm->rowCount())
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
                                        foreach($errors as $error)
                                            {
                                                echo "<script>
                                                alert('$error');
                                                window.open('sign_up.php','_self');
                                                </script>";;
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
                                            <input type="file" name="image">
                                            <div class="form-group">
                                                <br>
                                                <label>Description</label>

                                                <textarea placeholder="Please Enter Description" required name="description" class="form-control"
                                                    cols="30" rows="3"></textarea>
                                            </div>
                                                <br>
                                            <div style="float:right;">
                                                <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
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
                                <i class="fa fa-tasks"></i> Categories
                            </div>
                            <?php
                                if(isset($_GET['action'],$_GET['id']))
                                {
                                    $id = $_GET['id'];
                                    switch($_GET['action'])
                                    {
                                        case "delete":
                                        $sql = "delete from categories where category_id=$id";
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
    $sql = "select * from categories";
    $stm = $con->prepare($sql);
    $stm -> execute();

    ?>

    <?php
    if($stm->rowCount())
    {
        foreach($stm->fetchAll() as $row)
        {
            $id = $row['category_id'];
            $category_name = $row['category_name'];
            $description = $row['description'];
            $image = $row['img_url'];

        ?>
        
    

    
        <div class="card">
            <div class="imgbx">
                <img src="images/upload/<?php echo $image; ?>">
            </div>

            <div class="content">
                <div class="productname">
                    <h3><?php echo $category_name; ?></h3>
                </div>

                <div class="priceRating">
                    <h2><?php echo $description; ?></h2>
                </div>
                <a href="edit_category.php?action=edit&id=<?php echo $id  ?>" class='btn btn-primary'>Edit</a>
                <a href="?action=delete&id=<?php echo $id  ?>" class='btn btn-danger' id="delete" onclick="return confirm('Are You Sure?');">Delete</a>
                 <br><br>
                <a href="?action=active&id=<?php echo $id ?>" class='btn btn-primary' name="active">active</a>
                <a href="?action=inactive&id=<?php echo $id ?>" class='btn btn-danger'  name="inactive">inactive</a>                                  
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

    
    <?php
if(isset($_GET['action'], $_GET['id']) && $_GET['action']=='active')
{

    $uid = $_GET['id'];
    $sql = "update categories set status='1' where category_id=$uid";
    $stm = $con->prepare($sql);
    $stm -> execute();
}
if(isset($_GET['action'], $_GET['id']) && $_GET['action']=='inactive')
{
    $uid = $_GET['id'];
    $sql = "update categories set status='0' where category_id=$uid";
    $stm = $con->prepare($sql);
    $stm -> execute();
}

?>
    
   
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