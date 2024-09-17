<?php $this->view("include/AdminHeader", $data) ?>
<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <!-- User list start -->
    <div class="container-fluid pt-4 px-4">
      <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold text-primary">Danh Sách Tài Khoản</h5>
          <form class="d-none d-md-flex w-50">
            <input id="search_user" class="form-control border-0" type="search" placeholder="Tìm kiếm">
          </form>
          <a href="<?= ROOT ?>AdminAddUser" type="button" class="btn btn-primary">
            <i class="fa-solid fa-circle-plus"></i> Thêm Người Dùng
          </a>
        </div>
        <div id="displayUserData">
        </div>
        <label id="sort" hidden></label>
        <label id="colSort" hidden></label>
      </div>
    </div>

  </div>
  <!-- Content End -->
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script>
  $(document).ready(function () {
    // hiển thị danh sách người dùng
    fetch_data();
    // hiển thị danh sách nhóm quyền để lựa chọn
    getAllRoleToSelect();
  });
  
  function getAllRoleToSelect() {
    $.ajax({
      url: "<?= ROOT ?>AdminRole/getAllRoleToSelect",
      type: 'post',
      success: function (data, status) {
        $('#roleSelect').html(data);
        $('#roleSelectUpdate').html(data);
      }
    });
  }

  // hiển thị danh sách người dùng có phân trang
  function fetch_data(page, keyword) {
    var colName = $('#colSort').val();
    var typeSort = $('#sort').val();
    $.ajax({
      url: "<?= ROOT ?>AdminUser/getAll",
      type: 'post',
      data: {
        page: page,
        keyword: keyword,
        column: colName,
        typeSort: typeSort
      },
      success: function (data, status) {
        $('#displayUserData').html(data);
      }
    });
  }

  // xử lý sự kiện khi nhập từ khóa tìm kiếm
  $('#search_user').on("keyup", function () {
    var searchText = $('#search_user').val();
    if (searchText.trim() == "") {
      fetch_data();
    } else {
      var currentPage = 1;
      fetch_data(currentPage, searchText);
    }
  });

  // hàm đổi trang
  function changePageFetch(page, keyword) {
    fetch_data(page, keyword);
  }


  function delete_user(id) {
    Swal.fire({
      title: "Bạn có chắc chắn muốn xóa tài khoản người dùng?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>index.php?url=AdminUser/delete",
          type: 'post',
          data: {
            deleteSend: id
          },
          success: function (data, status) {
            Swal.fire({
              title: data,
              icon: "success",
              confirmButtonColor: "#3459e6"
            }); fetch_data();
          }
        });
      }
    });
  }

  function ColSort(colName) {
    $('#colSort').val(colName);
    var searchText = $('#search_user').val();
    var typeSort = $('#sort').val();
    if (typeSort === 'ASC') {
      typeSort = 'DESC';
      $('#sort').val('DESC');
    } else {
      typeSort = 'ASC';
      $('#sort').val('ASC');
    }
    fetch_data(1, searchText);
  }


  $('#displayUserData').on('change', '.form-check-input', function () {
    var userId = $(this).val();
    var isChecked = $(this).is(':checked') ? 0 : 1;
    console.log(userId);
    console.log(isChecked);
    Swal.fire({
      title: "Bạn có chắc chắn muốn thay đổi trạng thái người dùng?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3459e6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Hủy",
      confirmButtonText: "Chắc chắn!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= ROOT ?>AdminUser/changeStatus",
          type: 'post',
          data: {
            id: userId,
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
      } else {
        $(this).prop('checked', $(this).is(':checked') ? false : true);
      }
    });
  });

</script>
<?php $this->view("include/AdminFooter", $data) ?>