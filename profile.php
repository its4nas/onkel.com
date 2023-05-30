<?php
session_start();
if(isset($_SESSION['user_info']))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/bootstrap.min.css"/> 
    <title>Profile</title>
</head>
<body>
<?php
include("header.php");
require("dbconnect.php");
?>

                <section class="vh-100" style="background-color: #f4f5f7;">
                <?php
                    if(isset($_GET['action'],$_GET['id']) && $_GET['action']=='profile')
                    {
                        $id = $_GET['id'];
                        $sql = "select * from users where id=$id";
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
                                            $sql = "update users set f_name=? ,l_name=?, img_url=?, email=? , password=?, phone=?, address=? where id=?";
                                            $stm = $con->prepare($sql);
                                            $stm -> execute(array($f_name, $l_name ,$new_img_name, $email, $password, $phone, $address, $id));
    
                                            if($stm->rowCount())
                                            {
                                                echo "<script>
                                                alert('One Row Updateed');
                                                window.open('profile.php?action=profile&id=$id','_self');
                                                </script>";

                                            }
                                            else
                                            {
                                                echo "<div class='alert alert-danger' >Row not updated </div>";
                                                
                                            }
                                        }
                                    }
                ?>

                
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-6 mb-4 mb-lg-0">
                        <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                            style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="images/upload/<?php echo $image; ?>" style="width: 80px;" class="rounded-circle img-fluid my-5" />
                            <h5><?php echo "$f_name" . " $l_name"?></h5>
                            <p><?php echo $address ?></p>
                            

                            <div class="mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class="far fa-edit mb-5"></i></button>
        <div class="modal text-muted" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                    
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
                                    <br>
                                    <div class="imgbx">
                                                <input type="file" name="image" value="images/upload/<?php echo $image; ?>">
                                                
                                             </div>
                                             <br>
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
                        <div class="modal-footer">
                            <button type="submit" name="edit_user"class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    

                            </div>
                            <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Information</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                <div class="col-6 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted"><?php echo $email ?></p>
                                </div>
                                <div class="col-6 mb-3">
                                    <h6>Phone</h6>
                                    <p class="text-muted"><?php echo $phone ?></p>
                                </div>
                                </div>
                                <h6>Properties</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                <div class="col-6 mb-3">
                                    <h6>Power</h6>
                                    <p class="text-muted"><?php if($role_name==1){echo "Custumer";} if($role_name==2){echo "admin";} ?></p>
                                </div>
                                
                                </div>
                                <div class="d-flex justify-content-start">
                                <a href="#"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                <a href="#"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php } } }?>
                </section>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
                <?php
}
else
{
  header("location:login.php");
}
?>
</body>
</html>