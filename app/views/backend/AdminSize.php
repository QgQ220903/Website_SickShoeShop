<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold">Danh sách kích cỡ</h5>
          <form class="d-none d-md-flex w-50">
            <input id="search_size" class="form-control border-0" type="search" placeholder="Tìm Kiếm">
          </form>
          <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#size_modal">
            <i class="fa-solid fa-circle-plus"></i> Thêm Kích Cỡ
          </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="size_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm Kích Cỡ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Kích Cỡ</label>
                    <input id="size_name" type="text" class="form-control" id="" placeholder="" name="size_name">
                    <span class="error_message" id="sizeName_Error"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="insert_btn" onclick="insert_size()" type="button" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Update modal -->
        <div class="modal fade" id="updateSize_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa Kích Cỡ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Kích Cỡ</label>
                    <input id="update_sizeName" type="text" class="form-control" placeholder="" name="size_name">
                    <input type="hidden" id="hidden_data">
                    <span class="error_message" id="updateSizeName_Error"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="" onclick="update_size()" type="button" class="btn btn-primary">Sửa</button>
              </div>
            </div>
          </div>
        </div>

        <div id="displaySizeData">

        </div>
      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>
  // hiển thị danh sách kích cỡ
  function fetch_data(page) {
    $.ajax({
      url: "<?= ROOT ?>AdminSize/getAll",
      type: 'post',
      data: {
        page: page
      },
      success: function (data, status) {
        $('#displaySizeData').html(data);
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
      url: "<?= ROOT ?>index.php?url=AdminSize/search",
      method: "POST",
      data: {
        keyword: keyword,
        page: page
      },
      success: function (data) {
        $("#displaySizeData").html(data);
      }
    })
  }


  $('#search_size').on("keyup", function () {
    var searchText = $(this).val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      search_data(searchText, currentPage);
    }
  })

  // thêm kích cỡ mới 
  function insert_size() {
    var size_name = $('#size_name').val();
    if (size_name.trim() == "") {
      $('#sizeName_Error').text("Vui lòng nhập tên kích cỡ");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminSize/checkDuplicate",
        type: 'post',
        data: {
          size_name: size_name
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Kích cỡ sản phẩm đã tồn tại",
              position: 'top',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.ajax({
              url: "<?= ROOT ?>index.php?url=AdminSize/insert",
              type: 'post',
              data: {
                size_name: size_name
              },
              success: function (data, status) {
                Swal.fire({
                  title: "Thành công",
                  text: "Thêm thành công kích cỡ sản phẩm",
                  position: 'top',
                  showConfirmButton: true,
                  confirmButtonColor: "#3459e6",
                  icon: "success",
                }); fetch_data();
                $('#size_name').val('');
                $('#sizeName_Error').text("");
                $('#size_modal').modal('hide');
              }
            });
          }
        }
      });
    }
  }

  //xóa kích cỡ
  function delete_size(id) {
    Swal.fire({
      title: "Bạn có chắc chắn muốn xóa kích cỡ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>index.php?url=AdminSize/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            Swal.fire({
              title: "Xóa thành công!",
              text: "Xóa thành công kích cỡ sản phẩm",
              icon: "success",
              confirmButtonColor: "#3459e6",
            }); fetch_data();
          }
        });

      }
    });
  }

  function get_detail(id) {
    $('#hidden_data').val(id);
    $.post("<?= ROOT ?>index.php?url=AdminSize/getByID", { id: id }, function (data, status) {
      var size_id = JSON.parse(data);
      $('#update_sizeName').val(size_id.name);

    });
    $('#updateSize_Modal').modal("show");

  }

  function update_size() {
    var update_sizeName = $('#update_sizeName').val();
    var hidden_data = $('#hidden_data').val();
    if (update_sizeName.trim() == "") {
      $('#updateSizeName_Error').text("Vui lòng nhập tên kích cỡ");
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminSize/checkDuplicate",
        type: 'post',
        data: {
          size_name: update_sizeName
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              title: "Đã tồn tại",
              text: "Kích cỡ sản phẩm đã tồn tại",
              position: 'top',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "error",
            });
          } else if (data == "Duy nhất") {
            $.post("<?= ROOT ?>index.php?url=AdminSize/update", { update_sizeName: update_sizeName, hidden_data: hidden_data }, function (data, status) {
              $('#updateSizeName_Error').text("Vui lòng nhập tên kích cỡ");
              $('#updateSize_Modal').modal('hide');
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Cập nhật thành công",
                text: "Cập nhật thành công kích cỡ sản phẩm",
                confirmButtonColor: "#3459e6",
              });
              fetch_data();
            });
          }
        }
      });
    }
  }


</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>