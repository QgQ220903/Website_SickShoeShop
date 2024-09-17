<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold text-primary">Danh sách màu sắc</h5>
          <form class="d-none d-md-flex w-50">
            <input id="search_color" class="form-control border-0" type="search" placeholder="Tìm Kiếm">
          </form>
          <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#color_modal">
            <i class="fa-solid fa-circle-plus"></i> Thêm Màu Sắc
          </a>
        </div>

        <!-- Modal thêm màu sắc -->
        <div class="modal fade" id="color_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm Màu Sắc</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Màu Sắc</label>
                    <input id="color_name" type="text" class="form-control" id="" placeholder="" name="color_name">
                    <span id="colorName_Error" class="error_message"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="insert_btn" onclick="insert_color()" type="button" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal cập nhật màu sắc -->
        <div class="modal fade" id="updateColor_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa Màu Sắc</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Màu Sắc</label>
                    <input id="update_colorName" type="text" class="form-control" placeholder="" name="color_name">
                    <input type="hidden" id="hidden_data">
                    <span id="updateColorName_Error" class="error_message"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="" onclick="update_color()" type="button" class="btn btn-primary">Sửa</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Danh sách màu sắc -->
        <div id="displayColorData">

        </div>
      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  // hiển thị danh sách màu sắc
  function fetch_data(page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminColor/getAll",
      method: "POST",
      data: {
        page: page
      },
      success: function (data) {
        $("#displayColorData").html(data);
      }
    })
  }
  fetch_data();


  // đổi trang toàn bộ danh sách
  function changePageFetch(id) {
    fetch_data(id);
  }

  // đổi trang khi tìm kiếm
  function changePageSearch(keyword, page) {
    search_data(keyword, page);
  }

  // tìm kiếm
  function search_data(keyword, page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminColor/search",
      method: "POST",
      data: {
        keyword: keyword,
        page: page
      },
      success: function (data) {
        $("#displayColorData").html(data);
      }
    })
  }
  // tìm kiếm 
  $('#search_color').on("keyup", function () {
    var searchText = $(this).val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      search_data(searchText, currentPage);
    }
  })

  // thêm màu sắc mới vào database
  function insert_color() {
    var color_name = $('#color_name').val();
    if (color_name.trim() == "") {
      $("#colorName_Error").text("Vui lòng nhập tên màu sắc");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminColor/checkDuplicate",
        type: 'post',
        data: {
          color_name: color_name
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Màu sắc sản phẩm đã tồn tại",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.ajax({
              url: "<?= ROOT ?>index.php?url=AdminColor/insert",
              type: 'post',
              data: {
                color_name: color_name
              },
              success: function (data, status) {
                Swal.fire({
                  title: "Thành công",
                  text: "Thêm thành công màu sắc sản phẩm",
                  position: 'center',
                  showConfirmButton: true,
                  confirmButtonColor: "#3459e6",
                  icon: "success",
                }); fetch_data();
                $('#color_name').val('');
                $('#color_modal').modal('hide');
                $("#colorName_Error").text("");
              }
            });
          }
        }
      })

    }
  }

  //xóa màu sắc
  function delete_color(id) {
    Swal.fire({
      title: "Bạn có chắc chắn muốn xóa màu sắc?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>index.php?url=AdminColor/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            if (data === "Lỗi khi xóa") {
              Swal.fire({
                title: "Xóa thất bại",
                text: "Lỗi khi xóa màu sắc",
                position: 'center',
                showConfirmButton: true,
                confirmButtonColor: "#3459e6",
                icon: "error",
              });
            } else {
              Swal.fire({
                title: "Xóa thành công!",
                text: "Xóa thành công màu sắc sản phẩm",
                icon: "success",
                confirmButtonColor: "#3459e6"
              });
            } fetch_data();
          }
        });
      }
    });
  }

  // lấy dữ liệu qua id
  function get_detail(id) {
    $('#hidden_data').val(id);
    $.post("<?= ROOT ?>index.php?url=AdminColor/getByID", { id: id }, function (data, status) {
      var color_id = JSON.parse(data);
      $('#update_colorName').val(color_id.name);

    });
    $('#updateColor_Modal').modal("show");

  }

  // cập nhật màu sắc
  function update_color() {
    var update_colorName = $('#update_colorName').val();
    var hidden_data = $('#hidden_data').val();
    if (update_colorName.trim() == "") {
      $('#updateColorName_Error').text("Vui lòng nhập tên màu sắc");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminColor/checkDuplicate",
        type: 'post',
        data: {
          color_name: update_colorName
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Màu sắc sản phẩm đã tồn tại",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.post("<?= ROOT ?>index.php?url=AdminColor/update", { update_colorName: update_colorName, hidden_data: hidden_data }, function (data, status) {
              $('#updateColor_Modal').modal('hide');
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Cập nhật thành công",
                text: "Cập nhật thành công màu sắc sản phẩm",
                confirmButtonColor: "#3459e6",
              });
              fetch_data();
              $('#color_name').val('');
              $('#color_modal').modal('hide');
              $("#colorName_Error").text("Vui lòng nhập tên màu sắc");
            });
          }
        }
      })
    }
  }


</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>