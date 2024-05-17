<?php $this->view("include/header", $data) ?>
<style>
  body {
    overflow: hidden;
    background-color:  rgba(52, 89, 230, 1);
  }
  header {
    background-color: white;
  }
</style>
<div class="container-fluid h-100">
  <div class="row mt-2">
    <div class="login-panel col-lg-4 col-md-6 col-sm-12 bg-white mx-auto p-4">
      <h5 class="text-center text-primary pt-3 fw-bold mb-4">ĐĂNG NHẬP</h5>
      <form>
        <div class="mb-3">
          <label for="email_login" class="form-label">Email</label>
          <input type="email" class="form-control" id="email_login">
          <span type="email" class="error_message" id="emailError_login">
        </div>
        <div class="mb-3">
          <label for="password_login" class="form-label">Mật Khẩu</label>
          <input type="password" class="form-control" id="password_login">
          <span type="email" class="error_message" id="passwordError_login">
        </div>
        <!-- <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Hiển thị mật khẩu</label>
        </div> -->
        <button id="login_btn" type="button" class="btn btn-primary w-100">Đăng Nhập</button>
      </form>
    </div>

  </div>
</div>
<script>
  const container = document.querySelector('.login-panel');

  // Simulate adding the active class after a short delay (adjust as needed)
  setTimeout(() => {
    container.classList.add('active');
  }, 500);
</script>

<script>

  $(document).ready(function () {
    $('#login_btn').click(function () {
      // Lấy dữ liệu từ form đăng nhập
      var email = $('#email_login').val();
      var password = $('#password_login').val();

      // Hàm kiểm tra email hợp lệ
      function isValidEmail(email) {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
      }

      // Kiểm tra đầu vào form đăng nhập
      var hasError = false;
      if (email.trim() === '') {
        $('#emailError_login').text('Địa chỉ email không được để trống');
        hasError = true;
      } else if (!isValidEmail(email)) {
        $('#emailError_login').text('Địa chỉ email không hợp lệ');
        hasError = true;
      } else {
        $('#emailError_login').text('');
      }

      if (password.trim() === '') {
        $('#passwordError_login').text('Mật khẩu không được để trống');
        hasError = true;
      } else {
        $('#passwordError_login').text('');
      }

      // Nếu không có lỗi, gửi dữ liệu đăng nhập qua AJAX
      if (!hasError) {
        $.ajax({
          url: '<?= ROOT ?>login/login',
          type: 'post',
          data: {
            email: email,
            password: password
          },
          success: function (data) {
            if (data == 'Đăng nhập thành công') {
              Swal.fire({
                title: "Đăng nhập thành công!",
                position: 'center',
                showConfirmButton: true,
                confirmButtonColor: "#3459e6",
                icon: "success",
              }).then((result) => {
                window.location.href = "<?= ROOT ?>";
              });
            } else if (data == 'Tài khoản không tồn tại') {
              Swal.fire({
                icon: "error",
                title: data,
                position: "center",
                confirmButtonColor: "#d33",
                footer: ''
              });
            }
          },

        });
      }
    });
  });

</script>