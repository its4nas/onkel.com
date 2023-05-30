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
    <title>Edit Users Page</title>
    
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                        <h2><i class="fa fa-tasks" style="margin-top:25px;"></i> Users</h2>


                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Edit user
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <?php
                                        if(isset($_GET['action'],$_GET['id']) && $_GET['action']=='edit')
                                        {
                                            $id = $_GET['id'];
                                            $sql = "select * from users where id = $id";
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
                                                    $password = $row['password'];
                                                    $phone = $row['phone'];
                                                    $address = $row['address'];
                                                    $role_name = $row['role_id'];


                                    function test_input($data) {
                                        $data = trim($data);
                                        $data = stripslashes($data);
                                        $data = htmlspecialchars($data);
                                        
                                        return $data;
                                        }
        
                                        if(isset($_POST['edit_user']))
                                        {
                                            $id = $_POST['id'];
                                            $f_name = test_input($_POST['f_name']);
                                            $l_name = test_input($_POST['l_name']);
                                            $file = $_FILES['image'];
                                            $email = test_input($_POST['email']);
                                            $password = trim($_POST['password']);
                                            $phone = trim($_POST['phone']);
                                            $address = trim($_POST['address']);
                                            $role_name = $_POST['role'];

                                            
        
                                            $errors = array();
        
                                            if(is_numeric($f_name) || is_numeric($l_name))
                                            {
                                                $errors['f_name'] = "First Name must be string";
                                                $errors['l_name'] = "Last Name must be string";
                                            }

                                            if($_FILES['image']['error'] != 4)
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
                                        }    
                                    }
                                    else
                                    {
                                        $sql = "select img_url from users where id=$id";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute();
                                        $new_img_name = $stm -> fetch(){'img_url'};
                                    }


                                            if(empty($errors))
                                            {
                                                $sql = "update users set f_name=? ,l_name=?, img_url=?, email=? , password=?, phone=?, address=?, role_id=? where id=?";
                                                $stm = $con->prepare($sql);
                                                $stm -> execute(array($f_name, $l_name ,$new_img_name, $email, $password, $phone, $address, $role_name, $id));
        
                                                if($stm->rowCount())
                                                {
                                                    echo "<script>
                                                    alert('One Row Updateed');
                                                    window.open('users.php','_self');
                                                    </script>";

                                                }
                                                else
                                                {
                                                    echo "<div class='alert alert-danger' >Row not updated </div>";
                                                    
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


                                    ?>
                                     <div class="col-md-12">
                                <form role="form"  method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id  ?>">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" placeholder="Please Enter your First Name " name="f_name" value="<?php echo $f_name ?>" class="form-control" required />
                                        <i style="color:red;"><?php
                                                        if(isset($errors['f_name']))
                                                        echo $errors['f_name'];
                                                    ?></i>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" placeholder="Please Enter your Last Name " required name="l_name" value="<?php echo $l_name ?>" class="form-control"  />
                                        <i style="color:red;"><?php
                                                        if(isset($errors['l_name']))
                                                        echo $errors['l_name'];
                                                    ?></i>
                                    </div>
                                    <div class="imgbx">
                                                <input type="file" name="image" value="images/upload/<?php echo $image; ?>">
                                                <img src="images/upload/<?php echo $image; ?>" width=200px;>
                                             </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" required name="email" value="<?php echo $email ?>" placeholder="PLease Enter Eamil"  />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" required name="password" value="<?php echo $password ?>" placeholder="Please Enter password" >
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control"  required name="phone" value="<?php echo $phone ?>" placeholder="Please Enter Your Phone Number" >
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control"  name="address" value="<?php echo $address ?>" placeholder="Please Enter Your Address">
                                    </div>
                                    <div class="form-group">
                                        <label>User Type</label>
                                        <select class="form-control" name="role">
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
                                        <button type="submit" name="edit_user" class="btn btn-primary" onclick="return confirm('Are You Sure?');">Edit User</button>
                                        <button type="reset" class="btn btn-danger" >Cancel</button>
                                    </div>

                            </div>
                            </form>
                            <?php } } } ?>
                        </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>



        <!-- <input type="submit" name="cancel" value="cancel" onclick="goPrev()"/>
<script>
  function goPrev()
  {
    window.history.back();
  }
</script> -->
    
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
<?php include("footer.php") ?>
