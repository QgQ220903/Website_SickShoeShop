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
<div class="container-fluid h-100 mb-5">
  <div class="row mb-5">
    <div class="login-panel col-lg-4 col-md-6 col-sm-12 bg-white mx-auto p-4">
      <h5 class="text-center text-primary pt-3 mb-3 fw-bold">ĐĂNG KÝ</h5>
      <form action="" method="post">
        <div class="input-group mb-3 d-flex flex-column">
          <div class="">
            <label class="form-label mb-2">Tên Đăng Nhập</label>
            <input type="text" class="form-control" name="username" id="username_register" value="">
          </div>
          <span class="error_message" name="" id="usernameError_register">
        </div>
        <div class="input-group mb-3 d-flex flex-column">
          <div class="">
            <label class="form-label mb-2">Số Điện Thoại</label>
            <input type="tel" class="form-control" name="phone" id="phone_register" value="">
          </div>
          <span class="error_message" name="" id="phoneError_register">
        </div>
        <div class="input-group mb-3 d-flex flex-column">
          <div class="">
            <label class="form-label mb-2" for="">Email</label>
            <input type="email" class="form-control" name="email" id="email_register" value="">
          </div>
          <span class="error_message" name="" id="emailError_register">
        </div>
        <div class="input-group mb-3 d-flex flex-column">
          <div class="">
            <label class="form-label mb-2" for="">Mật Khẩu</label>
            <input id="password_register" type="password" class="form-control" name="password_register">
          </div>
          <span class="error_message" name="" id="passwordError_register">
        </div>
      </form>
      <button id="register_btn" class="btn btn-primary w-100">Đăng Ký</button>
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
  $('#register_btn').click(function () {
    // Lấy dữ liệu từ form đăng ký
    var username = $('#username_register').val();
    var phone = $('#phone_register').val();
    var email = $('#email_register').val();
    var password = $('#password_register').val();

    // Hàm kiểm tra số điện thoại hợp lệ
    function isValidPhoneNumber(phone) {
      var phonePattern = /^\d{10}$/;
      return phonePattern.test(phone);
    }

    // Hàm kiểm tra email hợp lệ
    function isValidEmail(email) {
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
    }

    // Kiểm tra đầu vào form đăng ký
    var hasError = false;
    if (username.trim() === '') {
      $('#usernameError_register').text('Tên đăng nhập không được bỏ trống');
      hasError = true;
    } else {
      $('#usernameError_register').text('');
    }

    if (phone.trim() === '') {
      $('#phoneError_register').text('Số điện thoại không được bỏ trống');
      hasError = true;
    } else if (!isValidPhoneNumber(phone)) {
      $('#phoneError_register').text('Số điện thoại không hợp lệ');
      hasError = true;
    } else {
      $('#phoneError_register').text('');
    }

    if (email.trim() === '') {
      $('#emailError_register').text('Địa chỉ email không được để trống');
      hasError = true;
    } else if (!isValidEmail(email)) {
      $('#emailError_register').text('Địa chỉ email không hợp lệ');
      hasError = true;
    } else {
      $('#emailError_register').text('');
    }

    if (password.trim() === '') {
      $('#passwordError_register').text('Mật khẩu không được để trống');
      hasError = true;
    } else {
      $('#passwordError_register').text('');
    }

    // Nếu không có lỗi, gửi dữ liệu đăng ký qua AJAX
    if (!hasError) {
      $.ajax({
        url: '<?= ROOT ?>register/register',
        type: 'post',
        data: {
          username: username,
          password: password,
          email: email,
          phone: phone
        },
        success: function (data) {
          if (data == 'Email đã có tài khoản khác sử dụng') {
            Swal.fire({
              icon: "error",
              title: data,
              position: "center",
              footer: '',
              confirmButtonColor: "#3459e6",
            });
          } else if (data == 'Đăng ký thành công') {
            Swal.fire({
              icon: "success",
              title: data,
              position: "center",
              footer: '',
              confirmButtonColor: "#3459e6",
            }).then((result) => {
              window.location.href = "<?= ROOT ?>login";
            });
          }
        },
        error: function () {
          alert("Lỗi trong quá trình đăng ký. Vui lòng thử lại sau");
        }
      });
    }
  });
</script>