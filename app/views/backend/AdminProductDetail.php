<?php $this->view("include/AdminHeader", $data) ?>
<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>

  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>
    <div class="container-fluid pt-4 px-4">
      <div class="bg-light text-center rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="mb-0 fw-bold text-primary">Danh Sách Chi Tiết Sản Phẩm</h5>
          <a onclick='showAddBtn()' class="btn btn-primary" href="" data-bs-toggle="modal"
            data-bs-target="#addProductDetail_Modal"><i class="fa-solid fa-circle-plus"></i>
            Thêm Chi Tiết
          </a>
        </div>

        <!-- Modal -->
        <div class="modal modal-xl fade" id="addProductDetail_Modal" data-bs-backdrop="static" data-bs-keyboard="false"
          tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm chi tiết</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between mb-4 gap-3 ">
                  <select id="colors" class="form-select flex-grow-1" aria-label="Default select example">
                  </select>
                  <select id="sizes" class="form-select flex-grow-1" aria-label="Default select example">
                  </select>
                </div>

                <!-- <div class="mb-4 text-start">
                  <input type="file" class="form-control" id="productDetail_img">
                  <span class="error_message" id='productDetailImage_Error'></span>
                </div> -->
                <div class="table-responsive">
                  <table id="productDetailTable" class="table overflow-auto">
                    <thead>
                      <th>Sản Phẩm</th>
                      <th>Màu Sắc</th>
                      <th>Kích Cỡ</th>
                      <th>Giá Tiền</th>
                    </thead>
                    <tbody id="productDetailTableBody">

                    </tbody>
                    <tfoot>
                      <tr class="">
                        <td colspan="4 text-center d-flex flex-column">
                          <label class="btn btn-primary" for="productDetail_Image">Chọn Ảnh</label>
                          <img id="productDetail_Preview"
                            src="https://boxman.co.za/wp-content/uploads/2022/11/Gift-Box-D-2-21.jpeg"
                            style="width:150px; height:150px; object-fit: cover;" alt="">
                        </td>
                      </tr>
                      <input type="file" hidden id="productDetail_Image">
                      <input type="text" hidden id="productDetailImage_Temp">
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button id="insertProductDetail_btn" onclick="" type="button" class="btn btn-primary">Thêm</button>
                <button id="updateProductDetail_btn" onclick="updateProductDetail()" type="button"
                  class="btn btn-primary hide">Sửa</button>
              </div>
            </div>
          </div>
        </div>


        <!-- Modal -->
        <div class="modal modal-xl fade" id="updateProductDetail_Modal" data-bs-backdrop="static"
          data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa chi tiết</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <span class="" id="productDetail_id" class="hidden"></span>
                <div class="d-flex align-items-center justify-content-between mb-4 gap-3 ">
                  <select id="colors_update" class="form-select flex-grow-1" aria-label="Default select example">
                  </select>
                  <select id="sizes_update" class="form-select flex-grow-1" aria-label="Default select example">
                  </select>
                </div>
                <div class="mb-4 text-start">
                  <label for="productDetailUpdate_price">Giá tiền</label>
                  <input type="text" class="form-control" id="productDetailUpdate_price" placeholder="Giá sản phẩm">
                </div>
                <label class="btn btn-primary" for="productDetailUpdate_Image">Chọn Ảnh</label>
                <img id="productDetailUpdate_Preview"
                  src="https://boxman.co.za/wp-content/uploads/2022/11/Gift-Box-D-2-21.jpeg"
                  style="width:150px; height:150px; object-fit: cover;" alt="">
                <input type="file" hidden id="productDetailUpdate_Image">
                <input type="text" hidden id="productDetailUpdateImage_Temp">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button id="updateProductDetail_btn" onclick="updateProductDetail()" type="button"
                  class="btn btn-primary hide">Sửa</button>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <input disabled type="text" id="product_id" class="form-control"
            value="<?= $data['product']->id ?> - <?= $data['product']->name ?>">
        </div>

        <!-- Danh sách sản phẩm -->
        <div id="productDetail_List">

        </div>
      </div>
    </div>

  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<script>
  $(document).ready(function () {
    var productDetails = []; // Mảng để lưu trữ các chi tiết sản phẩm
    var product_id = <?= $data['product']->id ?>;
    getAllProductDetailByProductID(product_id);
    getAllColor();
    // Lắng nghe sự kiện thay đổi file được chọn
    $('#productDetail_Image').change(function (event) {
      // Nhận tập tin được chọn
      const file = event.target.files[0];
      // Kiểm tra xem có tập tin nào được chọn hay không
      if (file) {
        $('#productDetailImage_Temp').val(file.name);
        // Tạo đối tượng FileReader để đọc tập tin
        const reader = new FileReader();
        // Xác định trình xử lý sự kiện onload cho FileReader
        reader.onload = function (event) {
          // Lấy ra Data URL của tập tin
          const dataURL = event.target.result;
          // Gán Data URL làm vào src cho 'avatar'
          $('#productDetail_Preview').attr('src', dataURL);

        };
        // Đọc tập tin dưới dạng Data URL
        reader.readAsDataURL(file);
      }
    });
    // Lắng nghe sự kiện thay đổi file được chọn
    $('#productDetailUpdate_Image').change(function (event) {
      // Nhận tập tin được chọn
      const file = event.target.files[0];
      // Kiểm tra xem có tập tin nào được chọn hay không
      if (file) {
        $('#productDetailUpdateImage_Temp').val(file.name);
        // Tạo đối tượng FileReader để đọc tập tin
        const reader = new FileReader();
        // Xác định trình xử lý sự kiện onload cho FileReader
        reader.onload = function (event) {
          // Lấy ra Data URL của tập tin
          const dataURL = event.target.result;
          // Gán Data URL làm vào src cho 'avatar'
          $('#productDetailUpdate_Preview').attr('src', dataURL);

        };
        // Đọc tập tin dưới dạng Data URL
        reader.readAsDataURL(file);
      }
    });

    // Gán sự kiện change cho các select box
    $('#colors').on("change", function () {
      getAllSize();
      // Xóa nội dung cũ của bảng
      $('#productDetailTableBody').empty();
      $('#productDetail_Preview').attr('src', "https://boxman.co.za/wp-content/uploads/2022/11/Gift-Box-D-2-21.jpeg");
    });

    // gán sự kiện cho mỗi lần chọn kích cỡ
    $('#sizes').on("change", function () {
      var product_id = <?= $data['product']->id ?>;
      var product_name = "<?= $data['product']->name ?>";
      var selectedColorValue = $('#colors').val();
      var selectedColorText = $('#colors').find(":selected").text();
      var selectedSizeValue = $(this).val();
      var selectedSizeText = $(this).find(":selected").text();

      // Lưu chi tiết sản phẩm vào mảng
      var productDetail = {
        product_id: product_id,
        color_id: selectedColorValue,
        size_id: selectedSizeValue,
        price: 0,
        image: ""
      };

      productDetails.push(productDetail);

      // Tạo hàng mới và thêm vào bảng
      var newRow = $('<tr>');
      var productNameCell = $('<td>').text(product_name);
      var colorCell = $('<td>').text(selectedColorText);
      var sizeCell = $('<td>').text(selectedSizeText);
      var priceCell = $("<td class='d-flex justify-content-center'>");
      var priceInput = $("<input class='form-control w-50'>").attr('type', 'text');
      priceCell.append(priceInput);

      if(selectedColorText == "Chọn màu sắc") {
        return;
      }

      if(selectedSizeText == "Chọn kích cỡ") {
        return;
      }
      newRow.append(productNameCell, colorCell, sizeCell, priceCell);
      $('#productDetailTableBody').append(newRow);
    });


    $('#insertProductDetail_btn').on("click", function () {
      // Lặp qua các dòng trong bảng
      $('#productDetailTableBody tr').each(function (index, row) {
        var priceInput = $(row).find('input[type="text"]');
        var priceValue = priceInput.val();
        var imageValue = $('#productDetailImage_Temp').val();


        // Cập nhật giá trị giá tiền trong mảng productDetails
        productDetails[index].price = priceValue;
        productDetails[index].image = imageValue;

        // Gọi AJAX để gửi dữ liệu productDetails đến server
        $.ajax({
          url: "<?= ROOT ?>AdminProductDetail/insert",
          type: 'post',
          data: {
            product_id: productDetails[index].product_id,
            color_id: productDetails[index].color_id,
            size_id: productDetails[index].size_id,
            productDetail_price: productDetails[index].price,
            productDetail_img: productDetails[index].image
          },
          success: function (response) {
            console.log(response);
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });

      });
      Swal.fire({
          title: "Thêm thành công!",
          text: "Thêm thành công chi tiết sản phẩm",
          position: 'center',
          showConfirmButton: true,
          confirmButtonColor: "#3459e6",
          icon: "success",
        });
        $('#addProductDetail_Modal').modal("hide");
        var product_id = <?= $data['product']->id ?>;
        getAllProductDetailByProductID(product_id);

      // Hiển thị thông tin chi tiết sản phẩm và giá tiền trong mảng productDetails
      console.log(productDetails);
    })

    // Gán sự kiện change cho các select box
    $('#colors_update').on("change", function () {
      getAllSize();
    });

  });


  // getAllProductDetailByProductID(product_id);
  // $('#updateProductDetail_btn').hide();
  // $('#insertProductDetail_btn').show();

  function showAddBtn() {
    $('#updateProductDetail_btn').hide();
    $('#insertProductDetail_btn').show();
  }


  function getAllProductDetailByProductID(product_id, page) {
    $.ajax({
      url: "<?= ROOT ?>AdminProductDetail/getAllProductDetail",
      type: "post",
      data: { product_id: product_id, page: page },
      success: function (data, status) {
        $('#productDetail_List').html(data);
      }
    });
  }

  // chuyển trang 
  function changePageFetch(page) {
    var product_id = $('#product_id').val();

    getAllProductDetailByProductID(product_id, page);
  }

  // lấy ra toàn bộ màu sắc 
  function getAllColor() {
    $.ajax({
      url: "<?= ROOT ?>AdminColor/getAllColor",
      type: "post",
      success: function (data, status) {
        $('#colors').html(data);
        $('#colors_update').html(data);
      }
    });
  }


  // lấy ra toàn bộ kích cỡ
  function getAllSize() {
    $.ajax({
      url: "<?= ROOT ?>AdminSize/getAllSize",
      type: "post",
      success: function (data, status) {
        $('#sizes').html(data);
        $('#sizes_update').html(data);
      }
    });
  }

  // lấy thông tin 1 chi tiết sản phẩm
  function get_detail(id) {
    getAllColor();
    getAllSize();
    $('#productDetail_id').val(id);
    $('#updateProductDetail_Modal').modal("show");
    $.ajax({
      url: "<?= ROOT ?>AdminProductDetail/getProductDetailByID",
      type: "post",
      data: { id: id },
      success: function (data, status) {
        // var proudct_detail = JSON.parse(data);
        alert(data);
        var product_detail = JSON.parse(data);
        $("#colors_update option").each(function () {
          if ($(this).text() === product_detail.color_name) {
            $(this).prop("selected", true);
          }
        });
        $("#sizes_update option").each(function () {
          if ($(this).text() === product_detail.size_name) {
            $(this).prop("selected", true);
          }
        });
        $("#productDetailUpdate_price").val(product_detail.price);
        $('#productDetailUpdate_Preview').attr('src', "<?= ASSETS ?>img/"  +  product_detail.image);
        $("#productDetailUpdateImage_Temp").val(product_detail.image);
      }
    });
  }

  
  function updateProductDetail() {
    var productDetail_id = $('#productDetail_id').val();
    var product_id = <?= $data['product']->id ?>;
    var color_id = $('#colors_update').val();
    var size_id = $('#sizes_update').val();
    var productDetail_price = $('#productDetailUpdate_price').val();
    if(!Number(productDetail_price)) {
      Swal.fire({
          text: "Sửa thất bại",
          position: 'center',
          showConfirmButton: true,
          confirmButtonColor: "#3459e6",
          icon: "error",
          });
          return;
    }
    var productDetailUpdate_Image = $('#productDetailUpdateImage_Temp').val();
    $.ajax({
      url: "<?= ROOT ?>AdminProductDetail/update",
      type: 'post',
      data: {
        productDetail_id: productDetail_id,
        product_id: product_id,
        color_id: color_id,
        size_id: size_id,
        productDetail_price: productDetail_price,
        productDetail_img: productDetailUpdate_Image
      },
      success: function (data, status) {
        console.log(data);
        if (data == "Thành công") {
          Swal.fire({
          title: "Sửa thành công!",
          text: "Sửa thành công chi tiết sản phẩm",
          position: 'center',
          showConfirmButton: true,
          confirmButtonColor: "#3459e6",
          icon: "success",
          });
          $('#updateProductDetail_Modal').modal("hide");
          getAllProductDetailByProductID(product_id);
        } else if (data == "Thất bại") {
          alert("Sửa thất bại");
          $('#updateProductDetail_btn').hide();
        }
      }
    });
  }

  // xóa 1 chi tiết sản phẩm
  function delete_ProductDetail(id) {
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
          url: "<?= ROOT ?>AdminProductDetail/delete",
          type: 'post',
          data: { id: id },

          success: function (data, status) {
            if (data == "Thành công") {
              Swal.fire({
                title: "Xóa thành công!",
                text: "Xóa thành công chi tiết sản phẩm",
                position: 'center',
                showConfirmButton: true,
                confirmButtonColor: "#3459e6",
                icon: "success",
              });
              var product_id = $('#product_id').val();
              getAllProductDetailByProductID(product_id);
            } else if (data == "Thất bại") {
              alert("Xóa thất bại");
            }
          }
        });
      }

    });

  }
</script>
<!-- <script>






  $('#products').on("change", function () {
    var product_name = $('#products option:selected').text();
    getAllProductDetailByProduct(product_name);
  });




  function getAllProduct() {
    $.ajax({
      url: "<?= ROOT ?>AdminProduct/getAllProduct",
      type: "post",
      success: function (data, status) {
        $('#products').html(data);
      }
    });
  }







  getAllProduct();
  getAllColor();
  getAllSize();


  

  


  function updateProductDetail() {
    var product_id = $('#products').val();
    var color_id = $('#colors').val();
    var size_id = $('#sizes').val();
    var productDetail_price = $('#productDetail_price').val();
    var fileInput = document.getElementById('productDetail_img');
    var file = fileInput.files[0];
    var fileName = file ? file.name : null;

    if (productDetail_price.trim() == '') {
      $('#productDetailPrice_Error').text("Vui lòng nhập giá sản phẩm");
    } else if (!file) {
      $('#productDetailImage_Error').text('Vui lòng chọn ảnh sản phẩm');
    } else {
      $('#productDetailPrice_Error').text("");
      $('#productDetailImage_Error').text('');
      $.ajax({
        url: "<?= ROOT ?>AdminProductDetail/checkDuplicate",
        type: 'post',
        data: { product_id: product_id, color_id: color_id, size_id: size_id },
        success: function (data, status) {
          if (data == "Tồn tại") {
            alert("Chi tiết sản phẩm đã tồn tại");
          } else if (data == "Duy nhất") {
            $.ajax({
              url: "<?= ROOT ?>AdminProductDetail/insert",
              type: 'post',
              data: { product_id: product_id, color_id: color_id, size_id: size_id, productDetail_price: productDetail_price, productDetail_img: fileName },
              success: function (data, status) {
                console.log(data);
                if (data == "Thành công") {
                  alert("Thêm thành công");
                  var product_name = $('#products option:selected').text();
                  getAllProductDetailByProduct(product_name);
                } else if (data == "Thất bại") {
                  alert("Thêm thất bại");
                } else {
                  alert("Không có gì xảy ra");
                }
              }
            });
          } else {
            alert("Không có gì xảy ra");
          }
        }
      });
    }
  }







</script> -->
<?php $this->view("include/AdminFooter", $data) ?>