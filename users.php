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
    <title>users Page</title>
    
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' />
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
            <div class="col-md-12">
                <h2><i class="fa fa-users" style="margin-top:25px;"></i> Users</h2>


            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-8">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus-circle"></i> Add New User
                    </div>
                    <?php
                            function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                
                                return $data;
                              }

                                if(isset($_POST['add_user']))
                                {
                                    $f_name = test_input($_POST['f_name']);
                                    $l_name = test_input($_POST['l_name']);
                                    $file= $_FILES['image'];
                                    $email =test_input($_POST['email']);
                                    $password = trim($_POST['password']);
                                    $phone = trim($_POST['phone']);
                                    $address = trim($_POST['address']);
                                    $role_id = $_POST['role'];


                                    $errors = array();

                                    if(is_numeric($f_name) || is_numeric($l_name))
                                    {
                                        $errors['f_name'] = "First Name must be string";
                                        $errors['l_name'] = "Last Name must be string";

                                    }
                                    
                                    if($_FILES['image']['error'] == 4)
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
                                        // $password_hashed = password_hash($password,PASSWORD_DEFAULT);
                                        $password_hashed = sha1($password);
                                        $sql = "INSERT INTO users( f_name, l_name,  img_url,email, phone, address, password, role_id) VALUES ( ? , ? ,? , ? , ? , ? , ? , ?)";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($f_name, $l_name, $new_img_name ,$email, $phone, $address, $password_hashed, $role_id));

                                        if($stm->rowCount())
                                        {
                                            echo "<script>
                                            alert('Row Inserted');
                                            window.open('users.php','_self');
                                            </script>";
                                        }
                                        
                                    }
                                    else
                                        {
                                            foreach($errors as $error)
                                            {
                                                echo "<script>
                                            alert('$error');
                                            window.open('users.php','_self');
                                            </script>";
                                            }
                                            
                                            
                                        }
                                }
                            }
                                }
                            ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form"  method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" placeholder="Please Enter your First Name " name="f_name" class="form-control" required />
                                        <i style="color:red;"><?php
                                                        if(isset($errors['f_name']))
                                                        echo $errors['f_name'];
                                                    ?></i>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" placeholder="Please Enter your Last Name " name="l_name" class="form-control" required />
                                    </div>
                                    <br>
                                        <label>Photo</label><br>
                                        <input type="file" name="image" class="form-control">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="PLease Enter Eamil" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Please Enter password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Please Enter Your Phone Number" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Please Enter Your Address" >
                                    </div>
                                    <div class="form-group">
                                        <label>User Type</label>
                                        <select class="form-control" name="role" >
                                        <?php
                                            $sql = "select * from roles";
                                            $stm = $con->prepare($sql);
                                            $stm -> execute();

                                            if($stm->rowCount())
                                            {
                                                foreach($stm->fetchAll() as $row)
                                                {
                                                ?>
                                               <option value=<?php echo $row['id'] ?>> <?php echo $row['name']  ?></option>
                                            <?php
                                                }
                                            }
                                            ?>                                      
                                            
                                            
                                        </select>
                                    </div>
                                    <br>
                                    <div style="float:right;">
                                        <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
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
                        <i class="fa fa-users"></i> Users
                    </div>

                    <?php
                                if(isset($_GET['action'],$_GET['id']))
                                {
                                    $id = $_GET['id'];
                                    switch($_GET['action'])
                                    {
                                        case "delete":
                                           
                                            
                                               
                                        $sql = "delete from users where id=$id";
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered bg-white table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <?php

                                    $sql = "select * from users ";
                                    $stm = $con->prepare($sql);
                                    $stm -> execute();

                                    if($stm -> rowCount())
                                    {                                        
                                        foreach ($stm->fetchAll() as $row)
                                        {
                                            $id = $row['id'];
                                            $f_name = $row['f_name'];
                                            $l_name = $row['l_name'];
                                            $image = $row['img_url'];
                                            $email = $row['email'];
                                            $phone = $row['phone'];
                                            $address = $row['address'];
                                            $role = $row['role_id'];
                                            $status = $row['status'];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $id ?></td>
                                    
                                    <td><img src="images/upload/<?php echo $image; ?>" style="width: 45px; height: 45px" class="rounded-circle" />
                                      <?php echo "$f_name" . " $l_name"?></td>
                                    <td><?php echo $email ?></td>
                                    <td> <?php echo $phone ?></td>
                                    <td> <?php echo $address ?></td>
                                    <td> <?php if($role==1) {echo "customer";} elseif($role == 2) {echo "admin";} else {echo "something went wrong";} ?></td>
                                    
                                    <td>
                                        <a href="edit_user.php?action=edit&id=<?php echo $id  ?>" class='btn btn-primary'>Edit</a>
                                        <a href="?action=delete&id=<?php echo $id  ?>" class='btn btn-danger' id="delete" onclick="return confirm('Are You Sure?');">Delete</a>
                                        
                                    </td>
                                    <td>
                                        
                                    
                                        <form action="" method="post">
                                        <a href="?action=active&id=<?php echo $id ?>" class='btn btn-primary' type="submit" name ="active">active</a>
                                        <a href="?action=inactive&id=<?php echo $id ?>" class='btn btn-danger' name="inactive">inactive</button>
                                        </form>
                                    </td>

                                </tr>

                                <?php
                                        }
                                    }
                                ?>


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
if(isset($_GET['action'], $_GET['id']) && $_GET['action']=='active')
{

    $uid = $_GET['id'];
    $sql = "update users set status='1' where id=$uid";
    $stm = $con->prepare($sql);
    $stm -> execute();
}
if(isset($_GET['action'], $_GET['id']) && $_GET['action']=='inactive')
{
    $uid = $_GET['id'];
    $sql = "update users set status='0' where id=$id";
    $stm = $con->prepare($sql);
    $stm -> execute();
}

?>
<?php
}
else
{
  header("location:login.php");
}
include("footer.php");
?>

