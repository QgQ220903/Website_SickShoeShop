<?php $this->view("include/AdminHeader", $data) ?>
<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>
    <div class="container-fluid pt-4 px-4">
      <div class="bg-light text-center rounded p-4">
        <div class="row mb-4">
          <h5 class="col-12 fw-bold text-primary">SỬA SẢN PHẨM</h5>
          <form class="row text-start" action="" method="POST">
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Tên sản phẩm</label>
              <input id="product_name" class="form-control" type="text" value="<?= $data['product']->name ?>">
              <span class="error_message" id="productName_Error" type="text">
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Thể Loại</label>
              <select id="categories" class="form-select" aria-label="Default select example">

              </select>
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Thương Hiệu</label>
              <select id="brands" class="form-select" aria-label="Default select example">

              </select>
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Nhà Cung Cấp</label>
              <select id='suppliers' class="form-select" aria-label="Default select example">
              </select>
            </div>
            <div class="col-sm-12 mb-3 ">
              <label for="" class="mb-2">Mô tả</label>
              <textarea id="product_description" rows="7" class="form-control" type="text" value="">
                <?= $data['product']->description ?>
              </textarea>
            </div>
          </form>
        </div>

        <div class="p-4 d-flex flex-column flex-md-row gap-3">
          <button class="btn btn-primary flex-grow-1" onclick="update_product()">Lưu</button>
          <a href="<?= ROOT ?>AdminProduct" class="btn btn-danger flex-grow-1">Hủy</a>
        </div>

      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script>



  function getAllCategories(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminCategory/getAllCategories",
      type: "post",
      data: { category_id: id },
      success: function (data, status) {
        $('#categories').html(data);
      }
    });
  }

  function getAllBrands(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminBrand/getAllBrands",
      type: "post",
      data: { brand_id: id },
      success: function (data, status) {
        $('#brands').html(data);
      }
    });
  }

  function getAllSuppliers(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminSupplier/getAllSuppliers",
      type: "post",
      data: { supplier_id: id },
      success: function (data, status) {
        $('#suppliers').html(data);
      }
    });
  }

  getAllCategories(<?= $data['product']->category_id ?>);
  getAllBrands(<?= $data['product']->brand_id ?>);
  getAllSuppliers(<?= $data['product']->supplier_id ?>);

  function update_product() {
    var product_id = <?= $data['product']->id ?>;
    var product_name = $("#product_name").val();
    var product_category = $("#categories").val();
    var product_brand = $("#brands").val();
    var product_supplier = $("#suppliers").val();
    var product_description = $("#product_description").val();

    if (product_name.trim() == "") {
      $('#productName_Error').text("Vui lòng nhập tên sản phẩm");
    } else {
      $('#productName_Error').text("");
      $.ajax({
        url: "<?= ROOT ?>AdminProduct/update",
        type: "post",
        data: {
          product_name: product_name,
          product_category: product_category,
          product_brand: product_brand,
          product_supplier: product_supplier,
          product_description: product_description,
          product_id: product_id,
        },
        success: function (data, status) {
          if (data == "Sửa thành công") {
            Swal.fire({
              title: "Sửa thành công!",
              text: "Sửa thành công sản phẩm",
              position: 'top',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "success",
            }).then((result) => {
              var redirectUrl = "<?= ROOT ?>AdminProduct";
              window.location.href = redirectUrl;
            });
          } else if (data == "Sửa thất bại") {
            Swal.fire({
              title: "Sửa thất bại!",
              text: "Sửa sản phẩm thất bại",
              position: 'top',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "success",
            });
          } else {
            alert("Không có gì xảy ra");
          }
        }
      });
    }
  }

</script>
<?php $this->view("include/AdminFooter", $data) ?>