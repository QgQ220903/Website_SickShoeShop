<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <!-- Sign In Start -->
  <div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
      <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
          <form action="" method="POST">
            <div class="d-flex align-items-center justify-content-center mb-3">
              <a href="" class="text-decoration-none">
                <h3 class="text-primary">Sign In</h3>
              </a>
            </div>
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="email_admin" placeholder="Email" name="email">
              <label for="floatingInput">Email</label>
              <span class="text-danger" name="" id="emailError_admin">
            </div>
            <div class="form-floating mb-4">
              <input type="password" class="form-control" id="password_admin" placeholder="Password" name="password">
              <label for="floatingPassword">Password</label>
              <span class="text-danger" name="" id="passwordError_admin">
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Show password</label>
              </div>
              <a href="">Forgot Password</a>
            </div>
            <button id="login_btn" onclick="" type="button" class="btn btn-primary py-3 w-100 mb-4"
              name="btn_login">SIGN
              IN</button>
          </form>

        </div>
      </div>
    </div>
  </div>
  <!-- Sign In End -->
</div>

<script>
  $(document).ready(function () {
    $('#login_btn').click(function () {
      // Lấy dữ liệu từ form đăng nhập
      var email = $('#email_admin').val();
      var password = $('#password_admin').val();

      // Hàm kiểm tra email hợp lệ
      function isValidEmail(email) {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
      }

      // Kiểm tra đầu vào form đăng nhập
      var hasError = false;
      if (email.trim() === '') {
        $('#emailError_admin').text('Địa chỉ email không được để trống');
        hasError = true;
      } else if (!isValidEmail(email)) {
        $('#emailError_admin').text('Địa chỉ email không hợp lệ');
        hasError = true;
      } else {
        $('#emailError_admin').text('');
      }

      if (password.trim() === '') {
        $('#passwordError_admin').text('Mật khẩu không được để trống');
        hasError = true;
      } else {
        $('#passwordError_admin').text('');
      }

      // Nếu không có lỗi, gửi dữ liệu đăng nhập qua AJAX
      if (!hasError) {
        $.ajax({
          url: '<?= ROOT ?>index.php?url=AdminLogin/login',
          type: 'post',
          data: {
            email: email,
            password: password
          },
          success: function (data) {
            if (data == 'Đăng nhập thành công') {
              Swal.fire({
                icon: "success",
                title: "",
                text: data,
                position: "top",
                footer: ''
              }).then((result) => {
                window.location.href = '<?= ROOT ?>index.php?url=AdminHome';
              });
            } else if (data == 'Tài khoản không tồn tại') {
              Swal.fire({
                icon: "error",
                title: "",
                text: data,
                position: "top",
                footer: ''
              });
            }
          },
        });
      }
    });
  })

  // đăng nhập xử lý bằng ajax
  function login() {
    var email = $('#email').val();
    var password = $('#password').val();

    if (email.trim() == "") {
      alert("Vui lòng nhập email");
    } else if (password.trim() == "") {
      alert("Vui lòng nhập mật khẩu");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminLogin/login",
        type: 'post',
        data: {
          email: email,
          password: password
        },
        success: function (data, status) {
          alert("Đăng nhập thành công");
          window.location.href = "<?= ROOT ?>AdminHome"; // Chuyển hướng đến URL cụ thể
        },
        error: function (xhr, status, error) {
          alert("Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin đăng nhập.");
        }
      });
    }
  }
</script>

<?php
$this->view("include/AdminFooter", $data);
?>