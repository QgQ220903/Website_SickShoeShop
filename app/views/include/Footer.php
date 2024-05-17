<footer class="footer bg-primary text-white pt-5 pb-4">
  <div class="container-fluid text-center text-md-left">
    <div class="row text-center text-md-left">

      <div class="col-md-3 col-lg-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 ">SHOP NAME</h5>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum quidem hic quam magnam ratione, quibusdam
          tempora itaque repellendus unde dolore quae consectetur aperiam nostrum velit tempore? Minus quas
          accusantium iusto!</p>
      </div>

      <div class="col-md-2 col-lg-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 ">My Account</h5>
        <p>
          <a href="" class="text-white">Sign In</a>
        </p>
        <p>
          <a href="" class="text-white">My Wishlist</a>
        </p>
        <p>
          <a href="" class="text-white">View Cart</a>
        </p>
        <p>
          <a href="" class="text-white">Help</a>
        </p>
      </div>

      <div class="col-md-3 col-lg-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-4">About Us</h5>
        <p>
          <a href="" class="text-white">Privacy Policy</a>
        </p>
        <p>
          <a href="" class="text-white">Terms and Conditions</a>
        </p>
        <p>
          <a href="" class="text-white">Support</a>
        </p>
        <p>
          <a href="" class="text-white">Delivery Infomation</a>
        </p>
      </div>

      <div class=" col-md-4 col-lg-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4">Contact US</h5>
        <p>
          <a href="" class="text-white bi-envelope" style="text-decoration: none;"> nhomweb@gmail.com</a>
        </p>
        <p>
          <a href="" class="text-white bi-phone">+123456789</a>
        </p>
        <p>
          <a href="" class="text-white bi-hourglass">9:00 - 21:00,Mon - Sat</a>
        </p>
        <p>
          <a href="" class="text-white bi-facebook"></a>
          <a href="" class="text-white bi-instagram"></a>
          <a href="" class="text-white bi-twitter-x"></a>
          <a href="" class="text-white bi-youtube"></a>
        </p>
      </div>
    </div>

    <hr>
    <div class="row text-center text-md-left">
      <h5>Create with <i class="bi-heart-fill"></i> by <i class="bi bi-c-circle"></i>SickShoesShop</h5>
    </div>
  </div>
</footer>

<!-- END FOOTER -->


</body>

</html>
<script src="<?php echo ASSETS ?>js/bootstrap.bundle.js"></script>
<script>



  $(document).ready(function () {




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
          url: '<?= ROOT ?>index.php?url=register',
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
                title: "",
                text: data,
                position: "top",
                footer: '',
                confirmButtonColor: "#3459e6",
              });
            } else if (data == 'Đăng ký thành công') {
              Swal.fire({
                icon: "success",
                title: "",
                text: data,
                position: "top",
                footer: '',
                confirmButtonColor: "#3459e6",
              }).then((result) => {
                location.reload();
              });
            }
          },
          error: function () {
            alert("Lỗi trong quá trình đăng ký. Vui lòng thử lại sau");
          }
        });
      }
    });
  });



  function logout() {
    var action = 'logout';
    $.ajax({
      url: '<?= ROOT ?>index.php?url=logout/logout',
      method: "POST",
      data: { action: action },
      success: function (data) {
        window.location.href = "<?= ROOT ?>home";
      }
    });
  }

</script>

</body>

</html>