<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold">Danh sách thể loại</h5>
          <form class="d-none d-md-flex w-50">
            <input id="search_category" class="form-control border-0" type="search" placeholder="Tìm Kiếm">
          </form>
          <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#category_modal">
            <i class="fa-solid fa-circle-plus"></i> Thêm Thể Loại
          </a>
        </div>

        <!-- Modal thêm thể loại -->
        <div class="modal fade" id="category_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm Thể Loại</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Thể Loại</label>
                    <input id="category_name" type="text" class="form-control" id="" placeholder=""
                      name="category_name">
                    <span class="error_message" id="categoryName_Error"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="insert_btn" onclick="insert_category()" type="button" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal sửa thể loại -->
        <div class="modal fade" id="update_categorymodal" data-bs-backdrop="static" data-bs-keyboard="false"
          tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa Thể Loại</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label">Thể Loại</label>
                    <input id="update_categoryName" type="text" class="form-control" placeholder=""
                      name="update_categoryName">
                    <input type="hidden" id="hidden_data">
                    <span class="error_message" id="categoryNameUpdate_Error"></span>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Thoát</button>
                <button id="" onclick="update_category()" type="button" class="btn btn-primary">Sửa</button>
              </div>
            </div>
          </div>
        </div>

        <!-- danh sách thể loại -->
        <div id="displayDataTable" class="category_list">

        </div>



      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  // hiển thị danh sách, có phân trang
  function fetch_data(page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminCategory/getAll",
      method: "POST",
      data: {
        page: page
      },
      success: function (data) {
        $("#displayDataTable").html(data);
      }
    })
  }
  fetch_data();


  // chuyển trang
  function changePageFetch(id) {
    fetch_data(id);
  }

  // chuyển trang khi tìm kiếm
  function changePageSearch(keyword, page) {
    search_data(keyword, page);
  }


  // tìm kiếm
  function search_data(keyword, page) {
    $.ajax({
      url: "<?= ROOT ?>index.php?url=AdminCategory/search",
      method: "POST",
      data: {
        keyword: keyword,
        page: page
      },
      success: function (data) {
        $("#displayDataTable").html(data);
      }
    })
  }


  $('#search_category').on("keyup", function () {
    var searchText = $(this).val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      search_data(searchText, currentPage);
    }
  })


  //thêm mới vào database
  function insert_category() {
    var category_name = $('#category_name').val();
    if (category_name.trim() == "") {
      $('#categoryName_Error').text('Vui lòng nhập tên thể loại');
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminCategory/checkDuplicate",
        type: 'post',
        data: {
          category_name: category_name
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              position: "top",
              icon: "error",
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              title: "Đã tồn tại",
              text: "Thể loại sản phẩm đã tồn tại"
            });
            $('#category_name').val('');
            $('#categoryName_Error').text('');
            $('#category_modal').modal('hide');
          } else if (data == "Duy nhất") {
            $.ajax({
              url: "<?= ROOT ?>index.php?url=AdminCategory/insert",
              type: 'post',
              data: {
                category_name: category_name
              },
              success: function (data, status) {
                Swal.fire({
                  position: "top",
                  icon: "success",
                  title: "Thêm thành công",
                  text: "Bạn đã thêm mới thành công thể loại",
                  showConfirmButton: true,
                  confirmButtonColor: "#3459e6"
                }); fetch_data();
                $('#category_name').val('');
                $('#categoryName_Error').text('');
                $('#category_modal').modal('hide');
              }
            });
          }
        }
      })

    }
  }

  //xóa thể loại
  function delete_category(id) {
    Swal.fire({
      title: "Bạn có chắc chắn muốn xóa thể loại?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>index.php?url=AdminCategory/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            Swal.fire({
              title: "Xóa thành công",
              text: "Bạn đã xóa thành công thể loại",
              icon: "success",
              showConfirmButton: true,
              confirmButtonColor: "#3459e6"
            }); fetch_data();
          }
        });

      }
    });

  }

  // lấy dữ liệu qua id
  function get_detail(id) {
    $('#hidden_data').val(id);
    $.post("<?= ROOT ?>index.php?url=AdminCategory/getByID", { id: id }, function (data, status) {
      var category_id = JSON.parse(data);
      $('#update_categoryName').val(category_id.name);

    });
    $('#update_categorymodal').modal("show");

  }

  function update_category() {
    var update_categoryName = $('#update_categoryName').val();
    var hidden_data = $('#hidden_data').val();
    if (update_categoryName.trim() == "") {
      $('#categoryNameUpdate_Error').text('Vui lòng nhập tên thể loại');
    } else {
      $.ajax({
        url: "<?= ROOT ?>index.php?url=AdminCategory/checkDuplicate",
        type: 'post',
        data: {
          category_name: update_categoryName
        },
        success: function (data, status) {
          if (data == "Đã tồn tại") {
            Swal.fire({
              position: "top",
              icon: "error",
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              title: "Đã tồn tại",
              text: "Thể loại sản phẩm đã tồn tại"
            });
            $('#update_categorymodal').modal('hide');
            $('#update_categoryName').val('');
            $('#categoryNameUpdate_Error').text(''); $('#categoryName_Error').text('');
          } else if (data == "Duy nhất") {
            $.post("<?= ROOT ?>index.php?url=AdminCategory/update", { update_categoryName: update_categoryName, hidden_data: hidden_data }, function (data, status) {
              $('#update_categorymodal').modal('hide');
              $('#update_categoryName').val('');
              $('#categoryNameUpdate_Error').text('');
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Cập nhật thành công",
                text: "Bạn đã cập nhật thành công thể loại",
                showConfirmButton: true,
                confirmButtonColor: "#3459e6"
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