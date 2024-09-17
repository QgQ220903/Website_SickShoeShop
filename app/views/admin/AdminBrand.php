<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold text-primary">Danh sách thương hiệu</h5>

          <form class="d-none d-md-flex w-50">
            <input id="search_brand" class="form-control border-0" type="search" placeholder="Tìm Kiếm">
          </form>

          <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#brand_modal">
            <i class="fa-solid fa-circle-plus"></i> Thêm Thương Hiệu
          </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="brand_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm Thương Hiệu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Thương Hiệu</label>
                    <input id="brand_name" type="text" class="form-control" id="" placeholder="" name="brand_name">
                    <span class="error_message" id="brandName_Error"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="insert_btn" onclick="insert_brand()" type="button" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Update modal -->
        <div class="modal fade" id="updateBrand_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa Thương Hiệu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Thương Hiệu</label>
                    <input id="update_brandName" type="text" class="form-control" placeholder="" name="brand_name">
                    <input type="hidden" id="hidden_data">
                    <span class="error_message" type="text" id="updateBrandName_Error">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="" onclick="update_brand()" type="button" class="btn btn-primary">Sửa</button>
              </div>
            </div>
          </div>
        </div>


        <div id="displayBrandData">

        </div>
      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  // hiển thị danh sách thương hiệu
  function fetch_data(page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminBrand/getAll",
      type: 'post',
      data: {
        page: page
      },
      success: function (data, status) {
        $('#displayBrandData').html(data);
      }
    });
  }
  fetch_data();

  function changePageFetch(page) {
    fetch_data(page);
  }

  function changePageSearch(keyword, page) {
    search_data(keyword, page);
  }

  function search_data(keyword, page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminBrand/search",
      method: "POST",
      data: {
        keyword: keyword,
        page: page
      },
      success: function (data) {
        $("#displayBrandData").html(data);
      }
    })
  }


  $('#search_brand').on("keyup", function () {
    var searchText = $(this).val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      search_data(searchText, currentPage);
    }
  })

  // thêm thương hiệu mới vào database
  function insert_brand() {
    var brand_name = $('#brand_name').val();
    if (brand_name.trim() == "") {
      $('#brandName_Error').text("Vui lòng nhập tên thương hiệu");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminBrand/checkDuplicate",
        type: 'post',
        data: {
          brand_name: brand_name
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Thương hiệu sản phẩm đã tồn tại",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.ajax({
              url: "<?= ROOT ?>index.php?url=AdminBrand/insert",
              type: 'post',
              data: {
                brand_name: brand_name
              },
              success: function (data, status) {
                Swal.fire({
                  title: "Thêm thành công!",
                  text: "Thêm thành công thương hiệu sản phẩm",
                  position: 'center',
                  showConfirmButton: true,
                  confirmButtonColor: "#3459e6",
                  icon: "success",
                }); fetch_data();
                $('#brand_name').val('');
                $('#brandName_error').text("");
                $('#brand_modal').modal('hide');
              }
            });
          }
        }
      });

    }
  }

  //xóa thương hiệu
  function delete_brand(id) {
    Swal.fire({
      title: "Bạn có chắc chắn muốn xóa thương hiệu?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>index.php?url=AdminBrand/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            if (data === "Lỗi khi xóa") {
              Swal.fire({
                title: "Xóa thất bại",
                text: "Lỗi khi xóa thương hiệu",
                position: 'center',
                showConfirmButton: true,
                confirmButtonColor: "#3459e6",
                icon: "error",
              });
            } else {
              Swal.fire({
                title: "Xóa thành công!",
                text: "Xóa thành công thương hiệu sản phẩm",
                icon: "success",
                confirmButtonColor: "#3459e6"
              });
            }
            fetch_data();
          }
        });

      }
    });
  }

  function get_detail(id) {
    $('#hidden_data').val(id);
    $.post("<?= ROOT ?>index.php?url=AdminBrand/getByID", { id: id }, function (data, status) {
      var brand_id = JSON.parse(data);
      $('#update_brandName').val(brand_id.name);

    });
    $('#updateBrand_Modal').modal("show");

  }

  function update_brand() {
    var update_brandName = $('#update_brandName').val();
    var hidden_data = $('#hidden_data').val();
    if (update_brandName.trim() == "") {
      $('#updateBrandName_Error').text("Vui lòng nhập tên thương hiệu");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminBrand/checkDuplicate",
        type: 'post',
        data: {
          brand_name: update_brandName
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Thương hiệu sản phẩm đã tồn tại",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.post("<?= ROOT ?>index.php?url=AdminBrand/update", { update_brandName: update_brandName, hidden_data: hidden_data }, function (data, status) {
              $('#updateBrandName_Error').text("");
              $('#updateBrand_Modal').modal('hide');
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Cập nhật thành công",
                text: "Cập nhật thành công thương hiệu sản phẩm",
                confirmButtonColor: "#3459e6",
              }); fetch_data();
            });
          }
        }
      });
    }
  }
</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>