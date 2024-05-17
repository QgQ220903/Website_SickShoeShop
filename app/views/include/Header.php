<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?php echo $data['page_title'] ?>
  </title>

  <!-- Thêm Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- style css -->
  <link rel="stylesheet" href="<?php echo ASSETS ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo ASSETS ?>css/style.css" />

  <!-- gg fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">


  <!-- Icon Font Stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- BOOTSTRAP ICON CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="<?php echo ASSETS ?>img/logo.jpg" type="image/x-icon">

  <!-- JQUERY  -->
  <script src="<?php echo ASSETS ?>js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- gg fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

</head>

<body class="vh-100">
  <!-- HEADER -->
  <header>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand fs-4 fw-bold text-primary" href="<?= ROOT ?>Home">SICKSHOESHOP</a>

        <!-- Toggle Button -->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- SideBar -->
        <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <!-- SideBar header -->
          <div class="offcanvas-header text-primary border-bottom">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
              SICKSHOESHOP
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <!-- SideBar body -->
          <div class="offcanvas-body d-flex flex-column flex-lg-row">
            <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
              <li class="nav-item mx-auto mx-lg-2">
                <a class="nav-link " id="home" aria-current="page" href="<?= ROOT ?>home">Trang Chủ</a>
              </li>
              <li class="nav-item mx-auto mx-lg-2">
                <a class="nav-link " id="shop" href="<?= ROOT ?>shop">Sản Phẩm</a>
              </li>
              <li class="nav-item mx-auto mx-lg-2">
                <a class="nav-link " id="about" href="<?= ROOT ?>about">Giới Thiệu</a>
              </li>
              <li class="nav-item mx-auto mx-lg-2">
                <a class="nav-link " id="contact" href="<?= ROOT ?>contact">Liên Hệ</a>
              </li>
            </ul>
            <script>
              // Assuming you have a way to access the website title (e.g., document.title)
              const title = document.title.toLowerCase();  // Convert title to lowercase for case-insensitive matching

              const navLinks = document.querySelectorAll('.nav-link');

              navLinks.forEach(link => {
                const href = link.getAttribute('href');
                const targetPart = href.split('/').pop().toLowerCase();  // Extract the last part of the URL (assuming the page name is there)

                if (title.includes(targetPart)) {
                  link.classList.add('active');
                }
              });
            </script>
            <!-- Login / Sign up -->
            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
              <?php if (isset($data['user_data'])) {
                echo "                
                <div class='nav-item dropdown'>
                  <a href='#' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>
                  <i class='fa-solid fa-circle-user'></i>
                    <span class='d-flex align-items-center gap-2 d-lg-inline-flex'>
                      " . $data['user_data']->username . "
                    </span>
                  </a>
                  <div class='dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0'>
                    <a href='" . ROOT . "profile' class='dropdown-item'> <i class='fa-solid fa-circle-info'></i> Thông tin</a>
                    <a href='" . ROOT . "cart' class='dropdown-item'> <i class='fa-solid fa-cart-shopping'></i> Giỏ hàng</a>
                    <a href='" . ROOT . "order' class='dropdown-item'><i class='fa-solid fa-receipt'></i> Đơn hàng</a>
                  ";

                if ($data['user_data']->role_id != 5) {
                  echo "<a href='" . ROOT . "AdminHome' class='dropdown-item'> <i class='fa-solid fa-gear'></i> Quản trị</a>";
                }
                echo "
                    <a id='logout_btn' onclick='logout()' class='dropdown-item'> <i class='fa-solid fa-right-from-bracket'></i> Đăng xuất</a>
                  </div>
                </div>";
              } else {
                echo "
                <a class='text-decoration-none' href='" . ROOT . "login'>Đăng Nhập</a>
                <a href='" . ROOT . "register' class='text-white text-decoration-none px-4 py-2 bg-primary rounded-4'>Đăng Ký</a>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAVBAR -->
  </header>