<?php $this->view("include/AdminHeader", $data) ?>
<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>
    <div class="container-fluid pt-4 px-4">
      <div class="bg-light text-center rounded p-4">
        <div class="row mb-4">
          <h5 class="col-12 fw-bold text-primary">THÊM SẢN PHẨM</h5>
          <form class="row text-start" action="" method="POST">
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Tên sản phẩm</label>
              <input id="product_name" class="form-control" type="text" value="">
              <span id="productName_Error" class="error_message"></span>
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Thể Loại</label>
              <select id="categories" class="form-select" aria-label="Default select example">
              </select>
              <span id="category_error" class="error_message"></span>
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Thương Hiệu</label>
              <select id="brands" class="form-select" aria-label="Default select example">
              </select>
              <span id="brand_error" class="error_message"></span>
            </div>
            <div class="col-sm-12 col-md-6 mb-3 ">
              <label for="" class="mb-2">Nhà Cung Cấp</label>
              <select id='suppliers' class="form-select" aria-label="Default select example">
              </select>
              <span id="supplier_error" class="error_message"></span>
            </div>
            <div class="col-sm-12 mb-3 ">
              <label for="" class="mb-2">Mô tả</label>
              <textarea id="product_description" rows="7" class="form-control" type="text" value=""></textarea>
              <span id="productDescription_Error" class="error_message"></span>
            </div>
          </form>
        </div>

        <div class="p-4 d-flex flex-column flex-md-row gap-3">
          <button class="btn btn-primary flex-grow-1" onclick="addProduct()">Thêm</button>
          <a href="<?= ROOT ?>AdminProduct" class="btn btn-danger flex-grow-1">Hủy</a>
        </div>


      </div>
    </div>
  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<script>

  function getAllCategories() {
    $.ajax({
      url: "<?= ROOT ?>AdminCategory/getAllCategories",
      type: "post",
      data: { category_id: 0 },
      success: function (data, status) {
        $('#categories').html(data);
      }
    });
  }

  function getAllBrands() {
    $.ajax({
      url: "<?= ROOT ?>AdminBrand/getAllBrands",
      type: "post",
      data: { brand_id: 0 },
      success: function (data, status) {
        $('#brands').html(data);
      }
    });
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

  getAllCategories();
  getAllBrands();
  getAllSuppliers();


  function addProduct() {
    var product_name = $("#product_name").val();
    var product_category = $("#categories").val();
    var product_brand = $("#brands").val();
    var product_supplier = $("#suppliers").val();
    var product_description = tinymce.activeEditor.getContent("myTextarea");
    var hasError = true;
    if (product_name.trim() == "") {
      $('#productName_Error').text("Vui lòng nhập tên sản phẩm");
      hasError = true;
    } else {
      $('#productName_Error').text("");
      hasError = false;
    }
    if (product_category == 0) {
      $('#category_error').text("Vui lòng nhập chọn thể loại sản phẩm");
      hasError = true;
    } else {
      $('#category_error').text("");
      hasError = false;
    }
    if (product_brand == 0) {
      $('#brand_error').text("Vui lòng chọn thương hiệu sản phẩm");
      hasError = true;
    } else {
      $('#brand_error').text("");
      hasError = false;
    }
    if (product_supplier == 0) {
      $('#supplier_error').text("Vui lòng chọn nhà cung cấp sản phẩm");
      hasError = true;
    } else {
      $('#supplier_error').text("");
      hasError = false;
    }
    if (product_description.trim() == "") {
      $('#productDescription_Error').text("Vui lòng nhập mô tả sản phẩm");
      hasError = true;
    } else {
      $('#productDescription_Error').text("");
      hasError = false;
    }

    if (!hasError) {
      $.ajax({
        url: "<?= ROOT ?>AdminProduct/insert",
        type: "post",
        data: {
          product_name: product_name,
          product_category: product_category,
          product_brand: product_brand,
          product_supplier: product_supplier,
          product_description: product_description,
        },
        success: function (data, status) {
          if (data == "Thêm thành công") {
            Swal.fire({
              title: "Thêm thành công!",
              text: "Thêm thành công sản phẩm",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "success",
            }).then((result) => {
              var redirectUrl = "<?= ROOT ?>AdminProduct";
              window.location.href = redirectUrl;
            });
          } else if (data == "Thêm thất bại") {
            Swal.fire({
              title: "Thêm thất bại!",
              text: "Thêm sản phẩm thất bại",
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "success",
            });
          }
        }
      });
    }


  }

</script>
<?php $this->view("include/AdminFooter", $data) ?>