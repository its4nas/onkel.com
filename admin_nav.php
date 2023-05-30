<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>Admin page</title>
  </head>

  <body>



<!-- top navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
          href="#"
          >Onkel.com</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
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
                <li><a class="dropdown-item" href="profile.php?action=profile&id=<?php echo $_SESSION['user_info']['id'] ?>"><i class="bi bi-person-circle"></i> Profile</a></li>
                <!-- <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li> -->
                <li>
                  <a class="dropdown-item" href="sign_out.php"><i class="bi bi-box-arrow-right"></i> sign out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-primary"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3">
                <h6 style="color: white;">Core</h6>
              </div>
            </li>
            <li>
              <a href="#" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                <h6 style="color: white;">Interface</h6>
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts"
              >
                
                <span class="bi bi-house-door"> Main</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="users.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-person-plus"></i
                      ></span>
                      <span>Add User</span>
                    </a>
                  </li>
                  <!-- <li>
                    <a href="users.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-person-x"></i
                      ></span>
                      <span>Delete User</span>
                    </a>
                  </li> -->
                  <li>
                    <a href="users.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi-person-lines-fill"></i
                      ></span>
                      <span>Edit User</span>
                    </a>
                  </li>
                  <li>
                    <a href="admin_products.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-cart-plus"></i
                      ></span>
                      <span>Add Product</span>
                    </a>
                  </li>
                  <li>
                    <a href="admin_products.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-cart-x"></i
                      ></span>
                      <span>Delete Product</span>
                    </a>
                  </li>
                  <li>
                    <a href="category.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-cart-x"></i
                      ></span>
                      <span>Add category</span>
                    </a>
                  </li>
                  <li>
                    <a href="category.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-cart-x"></i
                      ></span>
                      <span>Delete category</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            
            <li>
              <a href="comments.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-chat-dots"></i></span>
                <span>Comments</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                <h6 style="color: white;">Addons</h6>
              </div>
            </li>
            <li>
              <a href="admin.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                <span>Charts</span>
              </a>
            </li>
            
            <li>
              <a href="admin.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>user Table</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

        
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


