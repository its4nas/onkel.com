<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="css/card.css?version=1" />
    <link rel="stylesheet" href="css/product.css?version=1" />
    <script src="js/product.js" charset="utf-8"></script>
    <title>Onkel.com</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-label="Ninth navbar example">
    <div class="container-xl " >
      <a class="navbar-brand" href="#">Onkel.com</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample07XL">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="main.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#categories"> <script>windows.open('main.php') </script>categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#contactid">Contact Us</a>
          </li>
          
        </ul>
        <form class="d-flex ms-auto my-3 my-lg-0">
            <div class="input-group">
              <input
                class="form-control"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php $id = $_SESSION['user_info']['id']; ?>
                <li><a class="dropdown-item" href="profile.php?action=profile&id=<?php echo $id ?>"><i class="bi bi-person-circle"></i> Profile</a></li>
                <!-- <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li> -->
                <li>
                  <a class="dropdown-item" href="sign_out.php"><i class="bi bi-box-arrow-right"></i> sign out</a>
                </li>
              </ul>
            </li>
          </ul>
          <a href="cart.php" style="font-size:25px;"><i class="bi bi-cart4 text-white "></i></a>
          
      </div> 
    </div>
  </nav>

<script src="js/bootstrap.bundle.min.js"></script>
