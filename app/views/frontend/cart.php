<?php $this->view("include/header", $data) ?>

<!-- Cart Start -->
<div class="container-fluid pt-5 h-100">
  <div class="row px-xl-5">
    <h5 class="fw-bold mb-2 text-primary">Giỏ hàng của bạn</h5>
    <div id="cart" class="col-lg-12 table-responsive mb-5">
    </div>
  </div>
</div>
<!-- Cart End -->
<script>


  function getUserCart() {
    var user_id = <?= $data['user_data']->id ?>;
    $.ajax({
      url: "<?= ROOT ?>cart/getCartByUserID",
      method: "POST",
      data: { user_id: user_id },
      success: function (data, status) {
        $('#cart').html(data);
        console.log(data);

        // // Check for empty cart and update button state within success callback
        // const table = $("#cart");
        // const isEmpty = table.find("tr:not(:empty)").length === 0;
        // const placeOrderBtn = $("#place_order_btn");
        // if (true) {
        //   placeOrderBtn.prop("disabled", true); // Tắt nút (Disable button)
        // } else {
        //   placeOrderBtn.prop("disabled", false); // Bật nút (Enable button)
        // }
      }
    });
  }
  $(document).ready(function () {
    getUserCart();

  });

  function deleteCartDetail(id) {
    $.ajax({
      url: "<?= ROOT ?>CartDetail/deleteCartDetail",
      method: "POST",
      data: { id: id },
      success: function (data, status) {
        Swal.fire({
          title: data,
          position: 'center',
          showConfirmButton: true,
          confirmButtonColor: "#3459e6",
          icon: "success",
        });
        getUserCart();
      }
    });
  }


</script>
<?php $this->view("include/footer", $data) ?>