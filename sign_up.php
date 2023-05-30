<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/> 
    <title>sign up</title>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="facebook" viewBox="0 0 16 16">
    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
  </symbol>
  <symbol id="twitter" viewBox="0 0 16 16">
    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
  </symbol>
  <symbol id="github" viewBox="0 0 16 16">
  <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
  </symbol>
</svg>
</head>
<body>
    <?php require_once("dbconnect.php"); ?>
<section>
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            The best offer <br />
            <span class="text-primary">for your shopping</span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Eveniet, itaque accusantium odio, soluta, corrupti aliquam
            quibusdam tempora at cupiditate quis eum maiores libero
            veritatis? Dicta facilis sint aliquid ipsum atque?
          </p>
        </div>


        <?php
                            function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                
                                return $data;
                              }

                                if(isset($_POST['sign_up']))
                                {
                                    $f_name = test_input($_POST['f_name']);
                                    $l_name = test_input($_POST['l_name']);
                                    $email =test_input($_POST['email']);
                                    $password = trim($_POST['password']);
                                    $phone = trim($_POST['phone']);
                                    $address = trim($_POST['address']);


                                    $errors = array();

                                    if(is_numeric($f_name) || is_numeric($l_name))
                                    {
                                        $errors['f_name'] = "First Name must be string";
                                        $errors['l_name'] = "Last Name must be string";

                                    }
                                    if(empty($f_name) || empty($l_name) || empty($email) || empty($password))
                                    {
                                      $errors['empty'] = "all inputs are requried";
                                    }
                                    if(strlen($password)<8)
                                    {
                                      $errors['pass'] = "password is too short";
                                    }
                                    if(empty($errors))
                                    {
                                        $password_hashed = sha1($password);
                                        $sql = "INSERT INTO users( f_name, l_name ,email, phone, address, password) VALUES ( ? , ? ,? , ? , ? , ? )";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($f_name, $l_name ,$email, $phone, $address, $password_hashed ));

                                        if($stm->rowCount()==1)
                                        {
                                            echo "<script>
                                            alert('Row Inserted');
                                            window.open('login.php','_self');
                                            </script>";
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
                            
                                
                            ?>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">
              <form method="POST">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input type="text" id="form3Example1" name="f_name" class="form-control" />
                      <label class="form-label" for="form3Example1">First name</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input type="text" id="form3Example2" name="l_name" class="form-control" />
                      <label class="form-label" for="form3Example2">Last name</label>
                    </div>
                  </div>
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="email" id="form3Example3" name="email" class="form-control" />
                  <label class="form-label" for="form3Example3">Email address</label>
                </div>

                <!-- Phone input -->
                <div class="form-outline mb-4">
                  <input type="text" id="form3Example4" name="phone" class="form-control" />
                  <label class="form-label" for="form3Example4">Phone Number</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" id="form3Example5" name="password" class="form-control" />
                  <label class="form-label" for="form3Example4">Password</label>
                </div>
                 <!-- Password input -->
                 <div class="form-outline mb-4">
                  <input type="text" id="form3Example5" name="address" class="form-control" />
                  <label class="form-label" for="form3Example4">address</label>
                </div>

                <!-- Submit button -->
                <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit" name="sign_up">Sign up</button>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                  <label class="form-check-label" for="form2Example33">
                  By proceeding, you are confirming that you agree to our <a href="#">Terms and Conditions and Privacy Policy</a>
                  </label>

                </div>
                <div class="text-center">
                <a href="login.php">I already have an account</a>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<?php
  include("footer.php");
?>
</body>
</html>