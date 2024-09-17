<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="fw-bold text-primary">Danh sách phiếu nhập</h5>
          <a class="btn btn-primary" href="<?= ROOT ?>AdminProductImport/productImportForm">
            <i class="fa-solid fa-circle-plus"></i> Thêm Phiếu Nhập
          </a>
        </div>

        <div class="row mb-2">
          <div class="form-group col-lg-3">
            <label class="form-label" for="">Từ ngày</label>
            <input id="bgDate" class="form-control" type="date">
          </div>
          <div class="form-group col-lg-3">
            <label class="form-label" for="">Đến ngày</label>
            <input id="endDate" class="form-control" type="date">
          </div>
          <div class="form-group col-lg-3">
            <label class="form-label" for="">Nhân viên</label>
            <select id='users' class="form-select" aria-label="Default select example">
            </select>
          </div>
          <div class="form-group col-lg-3">
            <label class="form-label" for="">Nhà cung cấp</label>
            <select id='suppliers' class="form-select" aria-label=" Default select example">
            </select>
          </div>
        </div>

        <!-- Chi tiết phiếu nhập modal -->
        <div class="modal fade" id="invoice_detail_modal" data-bs-backdrop="static" data-bs-keyboard="false"
          tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Chi tiết phiếu nhập</h5>
              </div>
              <div class="modal-body row">
                <div class="mb-3 text-start col-lg-4">
                  <label class="mb-2" for="">Mã Phiếu Nhập</label>
                  <input id="" type="text" class="form-control" placeholder="" disabled>
                </div>
                <div class="mb-3 text-start col-lg-4">
                  <label class="mb-2" for="">Mã Nhà Cung Cấp</label>
                  <input id="" type="text" class="form-control" placeholder="" disabled>
                </div>
                <div class="mb-3 text-start col-lg-4">
                  <label class="mb-2" for="">Ngày Nhập</label>
                  <input id="" type="text" class="form-control" placeholder="" disabled>
                </div>
                <div class="col-sm-12 col-xl-12 table-responsive">
                  <table class="table table-striped">

                    <head>
                      <tr>
                        <th>Mã Chi Tiết Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Màu Sắc</th>
                        <th>Kích Cỡ</th>
                        <th>Số Lượng</th>
                        <th>Thành tiền</th>
                      </tr>
                    </head>
                  </table>
                </div>
                <p class="col-sm-12">
                  Tổng Tiền: <span class="text-danger">3.000.000đ</span>
                </p>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Thoát</button>
              </div>
            </div>
          </div>
        </div>

        <!-- danh sách phiêu nhập -->
        <div id="invoices" class="category_list">

        </div>

        <label id='sort' hidden></label>
        <label id='colSort' hidden></label>



      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  $(document).ready(function () {
    getAllSuppliers();
    getAllUserForOption();
    fetch_data();
  })

  function getInvoiceDetail(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminProductImport/getInvoiceFormByID",
      type: 'post',
      data: {
        id: id,
      },
      success: function (data, status) {
        $('#invoice_detail_modal').html(data);
      }
    });
    $('#invoice_detail_modal').modal("show");
  }

  // hiển thị danh sách phiếu nhập
  function fetch_data(page, keyword) {
    $.ajax({
      url: "<?= ROOT ?>AdminProductImport/getAllInvoices",
      type: 'post',
      data: {
        page: page,
        keyword: keyword
      },
      success: function (data, status) {
        $('#invoices').html(data);
      }
    });
  }

  // hàm khi nhấn vào số trang để đối trang
  function changePageFetch(page, keyword) {
    fetch_data(page, keyword);
  }

  // tìm kiếm nhóm quyền
  $('#endDate, #bgDate, #users, #suppliers').on("change", function () {
    SearchData();
  });

  function SearchData() {
    var col = $('#colSort').val();
    var endDate = $('#endDate').val();
    var bgDate = $('#bgDate').val();
    var nv = $('#users').find('option:selected').text();
    var ncc = $('#suppliers').find('option:selected').text();
    var sortType = $('#sort').val();
    if (ncc == "Chọn nhà cung cấp") {
      ncc = "";
    }
    if (nv == "Chọn nhân viên") {
      nv = "";
    }
    var currentPage = 1;

    if (bgDate != "" && endDate != "") {
      if (bgDate > endDate) {
        Swal.fire({
          title: "Warning!",
          text: "Ngày bắt đầu không được lớn hơn ngày kết thúc.",
          icon: "warning",
          confirmButtonColor: "#3459e6",
        });
        return;
      }
    }


    $.ajax({
      url: "<?= ROOT ?>AdminProductImport/getAllInvoices",
      type: 'post',
      data: {
        page: currentPage,
        endDate: endDate,
        bgDate: bgDate,
        nv: nv,
        ncc: ncc,
        col: col,
        sort: sortType
      },
      success: function (data, status) {
        $('#invoices').html(data);
      }
    });
  }

  function SortCol(ColName) {
    $('#colSort').val(ColName);
    var typeSort = $('#sort').val();
    if (typeSort === 'ASC') {
      typeSort = 'DESC';
      $('#sort').val('DESC');
    } else {
      typeSort = 'ASC';
      $('#sort').val('ASC');
    }
    SearchData();
  }

  function getAllSuppliers() {
    $.ajax({
      url: "<?= ROOT ?>AdminSupplier/getAllSuppliers",
      type: "post",
      data: { supplier_id: 0 },
      success: function (data, status) {
        $('#suppliers').html(data);
      }
    });
  }
  function getAllUserForOption() {
    $.ajax({
      url: "<?= ROOT ?>AdminUser/getAllUserForOption",
      type: "post",
      data: { user_id: 0 },
      success: function (data, status) {
        $('#users').html(data);
      }
    });
  }

</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>