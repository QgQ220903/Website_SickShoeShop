<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-2">
          <h5 class="fw-bold text-primary">Danh sách hoá đơn</h5>
        </div>

        <div class="row mb-2">
          <div class="form-group col-lg-4">
            <label class="form-label" for="">Từ ngày</label>
            <input id="bgDate" class="form-control" type="date">
          </div>
          <div class="form-group col-lg-4">
            <label class="form-label" for="">Đến ngày</label>
            <input id="endDate" class="form-control" type="date">
          </div>
          <div class="form-group col-lg-4">
            <label class="form-label" for="orderStatus">Phân loại</label>
            <select class="form-select" name="orderStatus" id="orderStatus">
              <option value="all">Tất cả</option>
              <option value="approved">Đã duyệt</option>
              <option value="unapproved">Chưa duyệt</option>
            </select>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="orderDetail_Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
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
        <!-- danh sách đơn hàng -->
        <div id="orders" class="category_list">

        </div>
        <label hidden id="col"></label>
        <label hidden id="sort"></label>



      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>
  var keyword;

  $(document).ready(function () {
    $('#orderStatus').change(handleOrderStatusChange);
    fetch_data();
  });

  // lấy ra chi tiết hóa đơn đưa vào form
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

  function handleOrderStatusChange(page) {
    if(page == null || isNaN(page)){
      page = 1;
    }
    var selectedOption = $('#orderStatus').val();
    switch (selectedOption) {
      case 'all':
        keyword = 'all';
        break;
      case 'approved':
        keyword = '1';
        break;
      case 'unapproved':
        keyword = '0';
        break;
      default:
        break;
    }
    fetch_data(page, keyword);
  }

  function changeOrderStatus(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminOrder/changeOrderStatus",
      type: 'post',
      data: { id: id },
      success: function (data, status) {
        alert(data);
      }
    });
  }

  $('#bgDate, #endDate').on('change',function(){
    var bgDate = $('#bgDate').val();
    var endDate = $('#endDate').val();
    if(bgDate!="" && endDate !=""){
      if(bgDate >= endDate){
        Swal.fire({
          title: "Ngày bắt đầu không thể lớn hơn ngày kết thúc!",
          icon: "warning",
          confirmButtonColor: "#3459e6"
        });
        return;
      }
    }
    handleOrderStatusChange();
  });

  function sortCol(colName){
    $('#col').val(colName);
    var typeSort = $('#sort').val();
    if (typeSort === 'ASC') {
      typeSort = 'DESC';
      $('#sort').val('DESC');
    } else {
      typeSort = 'ASC';
      $('#sort').val('ASC');
    }
    handleOrderStatusChange();
  }

  // hiển thị danh sách hoá đơn
  function fetch_data(page, keyword) {
    var col = $('#col').val();
    var sort = $('#sort').val();
    var bgDate = $('#bgDate').val();
    var endDate = $('#endDate').val();
    $.ajax({
      url: "<?= ROOT ?>AdminOrder/getAllOrder",
      type: 'post',
      data: {
        page: page,
        keyword: keyword,
        bgDate: bgDate,
        endDate: endDate,
        col: col,
        sort: sort
      },
      success: function (data, status) {
        $('#orders').html(data);
      }
    });
  }
  // hàm khi nhấn vào số trang để đối trang
  function changePageFetch(page, keyword) {
    handleOrderStatusChange(page);
  }


  $('#orders').on('change', '.form-check-input', function () {
    var orderId = $(this).val();
    var isChecked = $(this).is(':checked') ? 1 : 0;
    $.ajax({
      url: "<?= ROOT ?>AdminOrder/updateOrderStatus",
      type: 'post',
      data: {
        orderId: orderId,
        status: isChecked
      },
      success: function (data, status) {
        Swal.fire({
          title: data,
          icon: "success",
          confirmButtonColor: "#3459e6"
        }); fetch_data();
      }
    });
  });
</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>