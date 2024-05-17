<?php $this->view("include/header", $data) ?>

<!-- Checkout Start -->
<div class="container-fluid pt-5">
  <div class="row px-xl-5">
    <div class="col-lg-8">
      <div class="mb-4">
        <h4 class="font-weight-semi-bold mb-4">Thông tin nhận hàng</h4>
        <div class="row row-gap-3">
          <div class="col-md-12 form-group">
            <label>Họ và tên</label>
            <input id="name" class="form-control" type="text" placeholder="" value="<?= $data['user_data']->fullname ?>"
              disabled>
            <span id="name_error" class="error_message"></span>
          </div>
          <div class="col-md-12 form-group">
            <label>Email</label>
            <input id='email' disabled class="form-control" type="text" placeholder="example@email.com"
              value="<?= $data['user_data']->email ?>">
          </div>
          <div class="col-md-12 form-group">
            <label>Số điện thoại</label>
            <input id="phone" disabled class="form-control" type="text" placeholder="+123 4512 789"
              value="<?= $data['user_data']->phone ?>">
          </div>
          <div class='col-lg-4'>
            <div class=''>
              <label for='provinces'>Tỉnh / Thành phố</label>
              <select class='form-select' id='province'>
              </select>
              <span class='text-danger error_message' id='province_error'></span>
            </div>
          </div>
          <div class='col-lg-4'>
            <div class=''>
              <label for='districts'>Quận / Huyện</label>
              <select class='form-select' id='district'>
              </select>
              <span class='text-danger error_message' id='district_error'></span>
            </div>
          </div>
          <div class='col-lg-4'>
            <div class=''>
              <label for='wards'>Phường / Xã</label>
              <select class='form-select' id='ward'>
              </select>
              <span class='text-danger error_message' id='ward_error'></span>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <label>Địa chỉ cụ thể</label>
            <input id='address' class="form-control" type="text" placeholder="">
            <span id="address_error" class="error_message"></span>
          </div>
          <div class="col-md-12 form-group">
            <label>Phương thức thanh toán</label>
            <select id="payment_method" class="form-select" aria-label="Default select example">
              <option value="">Thanh toán khi nhận hàng</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card border-secondary mb-5">
        <div class="card-header bg-secondary border-0">
          <h4 class="font-weight-semi-bold m-0">Tổng Hóa Đơn</h4>
        </div>
        <div class="card-body">
          <!-- <h5 class="font-weight-medium mb-3">Sản Phẩm</h5> -->
          <?php
          $total = 0;
          foreach ($data['cart_data'] as $cart_item) {
            $subtotal = ($cart_item->price * 1.1) * $cart_item->quantity;
            $total += $subtotal;
            $subtotal = currency_format($subtotal);
            echo "
              <div id='cart_item' class='d-flex flex-column justify-content-between'>
                <p class='mb-0'>Tên sản phẩm:{$cart_item->product_detail_id} - {$cart_item->name}</p>
                <p class='mb-0'>Màu: {$cart_item->color_name} - Kích cỡ: {$cart_item->size_name}</p>
                <p class='mb-0'>Số lượng: {$cart_item->quantity}</p>
                <p class='mb-0'>Thành tiền: $subtotal</p>
                <hr>
              </div>
              ";
          }
          $vat = $total * 10 / 100;
          $order_total = $total + $vat;
          $order_total_format = currency_format($order_total);
          $total = currency_format($total);
          $vat = currency_format($vat);
          echo "
            <div class='d-flex justify-content-between pt-1'>
              <h6 class='font-weight-medium'>Tổng Tiền</h6>
              <h6 class='font-weight-medium'>{$total}</h6>
            </div>
            <div class='d-flex justify-content-between pt-1'>
              <h6 class='font-weight-medium'>VAT</h6>
              <h6 class='font-weight-medium'>{$vat}</h6>
            </div>
          ";
          ?>


        </div>
        <div class="card-footer border-secondary bg-transparent">
          <div class="d-flex justify-content-between">
            <h5 class="font-weight-bold">Thành Tiền</h5>
            <h5 class="font-weight-bold text-danger"><?= $order_total_format ?></h5>
          </div>
        </div>
        <button id="btn_place_order" href="" class="btn btn-primary font-weight-bold m-3">Đặt Hàng</button>
      </div>
    </div>
  </div>
</div>
<!-- Checkout End -->

<script>

  $(document).ready(function () {
    $.ajax({
      url: "<?= ROOT ?>Province",
      type: "post",
      data: {},
      success: function (data, status) {
        $('#province').html(data);
      }
    });

    $('#province').on("change", function () {
      var province_id = $('#province').val();
      $.ajax({
        url: "<?= ROOT ?>District",
        type: "post",
        data: { province_id: province_id },
        success: function (data, status) {
          $('#district').html(data);
          $('#ward').empty();  // This clears all existing options in wards select
        }
      });
    });

    $('#districts').on("change", function () {
      var district_id = $('#districts').val();
      $.ajax({
        url: "<?= ROOT ?>Ward",
        type: "post",
        data: { district_id: district_id },
        success: function (data, status) {
          $('#wards').html(data);
        }
      });
    });
    $('#district').on("change", function () {
      var district_id = $('#district').val();
      $.ajax({
        url: "<?= ROOT ?>Ward",
        type: "post",
        data: { district_id: district_id },
        success: function (data, status) {
          $('#ward').html(data);
        }
      });
    });
  });



  $('#btn_place_order').on("click", function () {
    var isValid = true; // Start with true for initial validation
    var user_id = <?= $_SESSION['user_id'] ?>;
    var name = $('#name').val();
    var address = $('#address').val();
    var payment_method = $("#payment_method").find("option:selected").text();
    var order_total = <?= $order_total ?>;
    var district = $('#district').val();
    var province = $('#province').val();
    var ward = $('#ward').val();

    if (name.trim() == "") {
      $('#name_error').text("Vui lòng nhập họ tên người nhận hàng");
      isValid = false;
    } else {
      $('#name_error').text("");
      isValid = true;
    }

    if (province == 0) {
      $('#province_error').text("Vui lòng chọn tỉnh / thành phố");
      isValid = false;
    } else {
      $('#province_error').text('');
      isValid = true;
    }


    if (district == 0) {
      $('#district_error').text("Vui lòng chọn quận huyện");
      isValid = false;
    } else {
      $('#district_error').text('');
      isValid = true;
    }

    if (ward == 0) {
      $('#ward_error').text("Vui lòng chọn phường xã");
      isValid = false;
    } else {
      $('#ward_error').text('');
      isValid = true;
      if (address.trim() == "") {
        $('#address_error').text("Vui lòng nhập địa chỉ giao hàng");
        isValid = false;
      } else {
        $('#address_error').text("");
        isValid = true;
      }

    }

    if (isValid) {
      console.log("User id: " + user_id);
      console.log("Customer name: " + name);
      console.log("Address: " + address);
      console.log("Payment_method: " + payment_method);
      console.log("Order_total: " + order_total);

      var order_detail = {
        cartData: <?php echo json_encode($data['cart_data']); ?>,
      };
      console.log(order_detail);
      var user_id = <?= $_SESSION['user_id'] ?>;;
      $.ajax({
        url: '<?= ROOT ?>AdminUser/saveAddress',
        type: 'post',
        data: {
          address: address,
          province: province,
          district: district,
          ward: ward,
          user_id: user_id
        },
        success: function (data, status) {
          $.ajax({
            url: "<?= ROOT ?>checkout/place_order",
            type: "post",
            data: {
              user_id: user_id,
              customer_name: name,
              address: data,
              payment_method: payment_method,
              order_total: order_total,
              order_detail: JSON.stringify(order_detail)
            },
            success: function (data, status) {
              Swal.fire({
                icon: "success",
                title: "Thêm thành công",
                confirmButtonColor: "#3459e6",
              }).then((result) => {
                window.location.href = "<?= ROOT ?>shop";
              });;
            }
          });
        }
      });
    }
  });

</script>
<?php $this->view("include/footer", $data) ?>