<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
  <nav class="navbar bg-light navbar-light">
    <a href="adminhome" class="navbar-brand mx-4 mb-3">
      <h5 class="text-primary fw-bold"><i class="fa fa-hashtag me-2"></i>SICKSHOESHOP</h5>
    </a>
    <div class="d-flex align-items-center ms-4 mb-4">
      <div class="position-relative">
        <?php if (isset($data['user_data']))
          echo "<img class='rounded-circle' src='" . ASSETS . "img/{$data['user_data']->img}' alt='' style='width: 40px; height: 40px;'>";
        ?>
        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
        </div>
      </div>
      <?php if (isset($data['user_data']))
        echo "
      <div class='ms-3'>
        <h6 class='mb-0'>" . $data['user_data']->username . "</h6>
        <span>" . $data['user_data']->role_name . "</span>
      </div>";
      ?>

    </div>
    <div class="navbar-nav w-100">

      <a href="<?php echo ROOT ?>AdminHome" class="nav-item nav-link"><i class="fa fa-chart-pie"></i>Thống Kê</a>

      <?php
      $moduleName = "Đơn Hàng";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        echo "<a href='" . ROOT . "AdminOrder' class='nav-item nav-link'><i class='fa fa-file-invoice-dollar'></i>Đơn Hàng</a>";
      }
      ?>

      <?php
      $moduleName = "Nhà Cung Cấp";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        // Biến "Nhà Cung Cấp" tồn tại trong mảng $data['modules']
        echo "       
        <a href='" . ROOT . "AdminSupplier' class='nav-item nav-link'><i class='fa fa-box'></i>Nhà Cung Cấp</a>
        ";
      }
      ?>

      <?php
      $moduleName = "Sản Phẩm";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        echo "       
        <div class='nav-item dropdown'>
          <a href='" . ROOT . "AdminProduct' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'><i
            class='fa fa-box'></i>Sản Phẩm</a>
          <div class='dropdown-menu bg-transparent border-0'>
            <a href='" . ROOT . "AdminProduct' class='dropdown-item'>Sản Phẩm</a>
            <a href='" . ROOT . "AdminCategory' class='dropdown-item'>Thể Loại</a>
            <a href='" . ROOT . "AdminBrand' class='dropdown-item'>Thương Hiệu</a>
            <a href='" . ROOT . "AdminColor' class='dropdown-item'>Màu Sắc</a>
            <a href='" . ROOT . "AdminSize' class='dropdown-item'>Kích Cỡ</a>
          </div>
        </div>";
      }
      ?>

      <?php
      $moduleName = "Nhập Hàng";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        echo "       
        <a href='" . ROOT . "AdminProductImport' class='nav-item nav-link'><i class='fa-solid fa-box'></i>Nhập Hàng </a>";
      }
      ?>
      <?php
      $moduleName = "Phân Quyền";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        // Biến "Nhà Cung Cấp" tồn tại trong mảng $data['modules']
        echo "       
        <a href='" . ROOT . "AdminRole' class='nav-item nav-link'><i class='fa-solid fa-shield-halved'></i>Phân Quyền </a>";
      }
      ?>

      <?php
      $moduleName = "Người Dùng";
      $moduleNames = array_column($data['modules'], 'module_name');

      if (in_array($moduleName, $moduleNames)) {
        // Biến "Nhà Cung Cấp" tồn tại trong mảng $data['modules']
        echo "       
        <div class='nav-item dropdown'>
        <a href='" . ROOT . "AdminUser' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>
          <i class='fa-solid fa-user'></i> Người Dùng
        </a>
        <div class='dropdown-menu bg-transparent border-0'>
          <a href=' " . ROOT . "AdminUser' class='dropdown-item'>Danh sách người dùng</a>
          <a href='" . ROOT . "AdminAddUser' class='dropdown-item'>Thêm mới người dùng</a>
        </div>
      </div>  
        ";
      }
      ?>

    </div>
  </nav>
</div>
<!-- Sidebar End -->