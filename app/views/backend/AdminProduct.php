<?php $this->view("include/AdminHeader", $data) ?>
<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>
    <div class="container-fluid pt-4 px-4">
      <div class="bg-light text-center rounded p-4">

        <form class="d-none d-md-flex mb-3 justify-content-center">
          <input id="search_product" class="form-control border-0 w-50" type="search" placeholder="Tìm kiếm sản phẩm">
        </form>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="mb-0 fw-bold text-primary">DANH SÁCH SẢN PHẨM</h5>
          <a class="btn btn-primary" href="<?= ROOT ?>AdminAddProduct"><i class="fa-solid fa-circle-plus"></i>
            Thêm Sản Phẩm
          </a>
        </div>

        <!-- Danh sách sản phẩm -->
        <div id="displayProductData">

        </div>
      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script>
  // hiển thị danh sách sản phẩm có phân trang
  function fetch_data(page) {
    $.ajax({
      url: "<?= ROOT ?>AdminProduct/getAll",
      method: "POST",
      data: {
        page: page
      },
      success: function (data) {
        $("#displayProductData").html(data);
      }
    });
  }
  fetch_data();

  // chuyển trang
  function changePageFetch(page) {
    fetch_data(page);
  }

  // chuyển trang khi tìm kiếm
  function changePageSearch(keyword, page) {
    search_data(keyword, page);
  }

  // tìm kiếm sản phẩm
  function search_data(keyword, page) {
    $.ajax({
      url: "<?= ROOT ?>AdminProduct/search",
      method: "POST",
      data: {
        keyword: keyword,
        page: page
      },
      success: function (data) {
        $("#displayProductData").html(data);
      }
    });
  }


  $('#search_product').on("keyup", function () {
    var searchText = $(this).val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      search_data(searchText, currentPage);
    }
  });


  function get_detail(id) {

  }

  function delete_product(id) {
    Swal.fire({
      title: "Xóa sản phẩm?",
      text: "Bạn có chắc chắn muốn xóa sản phẩm?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>AdminProduct/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            Swal.fire({
              title: "Xóa thành công!",
              text: "Xóa thành công sản phẩm",
              icon: "success",
              confirmButtonColor: "#3459e6",
            }); fetch_data();
          }
        });
      }
    });
  }

</script>

<?php $this->view("include/AdminFooter", $data) ?>