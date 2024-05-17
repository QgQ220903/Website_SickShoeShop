<?php $this->view("include/header", $data) ?>
<div class="container-fluid pt-4 px-5">
  <div class="row bg-light p-4">
    <div class="col-12 d-flex align-items-center justify-content-between mb-3">
      <h6 class="mb-3">Đơn hàng của bạn</h6>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="orderDetail_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin đơn hàng</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-1">Mã đơn hàng: </p>
            <p class="mb-1">Tên khách hàng: </p>
            <p class="mb-1">Ngày đặt hàng: </p>
            <p class="mb-1">Địa chỉ giao hàng: </p>
            <p class="mb-1">Trạng thái: </p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Ảnh</th>
                  <th scope="col">Sản Phẩm</th>
                  <th scope="col">Màu Sắc</th>
                  <th scope="col">Kích Cỡ</th>
                  <th scope="col">Số Lượng</th>
                  <th scope="col">Thành Tiền</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                </tr>
              </tbody>
            </table>
            <div class="d-flex justify-content-end">
              Tổng tiền:
              <p class="text-danger fw-bold"> 6.000.000đ </p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
    <div id="displayOrderData">

    </div>
  </div>


</div>
<?php $this->view("include/footer", $data) ?>
<script>

  $(document).ready(function () {
    fetch_data();
  })
  function fetch_data(page) {
    var user_id = <?= $data['user_data']->id ?>;
    $.ajax({
      url: '<?= ROOT ?>order/getAll',
      method: "POST",
      data: {
        page: page,
        user_id: user_id
      },
      success: function (data, status) {
        $('#displayOrderData').html(data);
      }
    });
  }
  function changePageFetch(page) {
    fetch_data(page);
  }

  function getDetail(id) {
    $.ajax({
      url: '<?= ROOT ?>order/getDetail',
      method: "POST",
      data: {
        order_id: id
      },
      success: function (data, status) {
        $('#orderDetail_Modal').html(data);
      }
    });
    $('#orderDetail_Modal').modal("show");
  }

</script>