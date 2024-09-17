<?php $this->view("include/AdminHeader", $data) ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-light rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-bold">THÔNG TIN ĐƠN HÀNG</h5>
        </div>

        <div class="row">
          <div class=" col-lg-4">
            <label for="" class="mb-2">Nhân Viên</label>
            <input id="user_id" class="form-control mb-2" type="text" disabled value="<?= $_SESSION['user_id'] ?>">
          </div>
          <div class=" col-lg-4">
            <label for="" class="mb-2">Họ và tên khách hàng</label>
            <input id="customerNameInput" class="form-control mb-2" type="text" value="">

          </div>
          <div class=" col-lg-4">
            <label for="" class="mb-2">Số điện thoại khách hàng</label>
            <input id="customerPhoneInput" class="form-control mb-2" type="text" value="">

          </div>
          <div class=" col-lg-4">
            <label for="" class="mb-2">Tìm kiếm sản phẩm</label>
            <input type="text" id="productNameInput" class="form-control mb-2" placeholder="Nhập tên sản phẩm">

          </div>
          <div class=" col-lg-4">
            <label for="" class="mb-2">Sản Phẩm</label>
            <select id='products' class="form-select mb-2" aria-label="Default select example">
            </select>
          </div>
          <div class=" col-lg-4">
            <label for="" class="mb-2">Chi Tiết Sản Phẩm</label>
            <select id='productDetails' class="form-select mb-2" aria-label="Default select example">
            </select>
          </div>

          <div class='table-responsive mt-2'>
            <table id="productImportTable" class="table text-start align-middle table-bordered table-hover mb-0'">
              <thead>
                <tr>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Màu sắc</th>
                  <th>Kích cỡ</th>
                  <th>Giá tiền</th>
                  <th>Số lượng</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <div class="action">
              <button onclick='getTableData()' id="saveInvoice" class="btn btn-primary">Lưu</button>
              <button id="cancelInvoice" class="btn btn-danger">Hủy</button>
            </div>
            <div>
              Tổng tiền
              <span id="total" class="text-danger fw-bold"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  $(document).ready(function () {

    // tìm kiếm sản phẩm
    function search_data(keyword) {
      $.ajax({
        url: "<?= ROOT ?>AdminProduct/searchProductForSelect",
        method: "POST",
        data: {
          keyword: keyword,
        },
        success: function (data) {
          $("#products").empty();

          // Parse JSON data
          let products;
          try {
            products = JSON.parse(data);
            console.log(products);
          } catch (error) {
            console.error("Error parsing JSON data:", error);
            $("#products").html('<p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>');
            return;
          }

          if (products.length > 0) {
            products.forEach(product => {
              let option = $('<option></option>')
                .val(product.id)
                .text(product.name);
              $("#products").append(option);
            });
          } else {
            $("#products").html('<p>Không tìm thấy sản phẩm</p>');
          }
        }
      });
    }


    $('#productNameInput').on("keyup", function () {
      var searchText = $(this).val();
      if (searchText.trim() == "") {
        getAllProductForSelect();
      } else {
        var currentPage = 1;
        search_data(searchText);
      }
    });



    updateContinueButtonVisibility();
    $("#productDetails").change(function () {
      const selectedProductDetailId = $(this).val();

      const tableBody = $("#productImportTable tbody");
      const existingRow = tableBody.find(`tr[data-product-id="${selectedProductDetailId}"]`);

      if (!existingRow.length) {
        $.ajax({
          url: "<?= ROOT ?>AdminProductDetail/getProductDetailByID",
          type: "POST", // Assuming POST request
          data: { id: selectedProductDetailId },
          success: function (data) {
            const productDetail = JSON.parse(data);
            let salePrice = (productDetail.price * 105) / 100;
            const newRow = $("<tr></tr>").appendTo(tableBody);
            newRow.attr("data-product-id", selectedProductDetailId);
            $("<td>").text(productDetail.id).appendTo(newRow);
            $("<td>").text(productDetail.product_name).appendTo(newRow);
            $("<td>").text(productDetail.color_name).appendTo(newRow);
            $("<td>").text(productDetail.size_name).appendTo(newRow);
            // Format price and display
            const formattedPrice = numeral(salePrice).format('0,0.00'); // Example format (customizable)
            $("<td>").text(formattedPrice).appendTo(newRow);

            // Add quantity cell with default value (replace with your logic)
            const quantityCell = $("<td><input class='quantity-input form-control form-control-sm' type='number' value='1' min='1'></td>").appendTo(newRow);

            // Add delete button cell
            const deleteCell = $("<td><button class='btn btn-danger delete-btn'><i class='fa-solid fa-trash'></i></button></td>").appendTo(newRow);
            updateContinueButtonVisibility();
            calculateProductSum();
            // Optional: Bind click event handler for delete button
            deleteCell.find('.delete-btn').click(function () {
              // Handle delete functionality (remove row, update server-side if needed)
              $(this).closest('tr').remove(); // Remove the row from the table
              // Implement logic to remove the product from the server-side (if applicable)
              updateContinueButtonVisibility();
              calculateProductSum();
            });
          },
          error: function (error) {
            console.error("Error fetching product detail:", error);
            // Handle errors appropriately
          }
        });
      } else {
        // Row with the ID already exists (optional: display a message?)
        alert("Sản phẩm đã được thêm vào giỏ");
      }
    });

    // Attach quantity change event handler directly to the input element
    $(document).on('change', '.quantity-input', function () {
      updateContinueButtonVisibility();
      calculateProductSum();
    });
  });

  function updateContinueButtonVisibility() {
    const saveInvoiceBtn = $("#saveInvoice");
    const cancelInvoiceBtn = $("#cancelInvoice");
    const tableBody = $("#productImportTable tbody");
    const hasProducts = tableBody.children().length > 0; // Kiểm tra xem danh sách có rỗng không

    if (hasProducts) {
      saveInvoiceBtn.show(); // hiển thị nút nếu có sản phẩm
      cancelInvoiceBtn.show();
    } else {
      saveInvoiceBtn.hide(); // ẩn nút lưu nếu như không có sản phẩm
      cancelInvoiceBtn.hide();
    }
  }



  function calculateProductSum() {
    const tableBody = $("#productImportTable tbody");
    let totalSum = 0;

    tableBody.find("tr").each(function () {
      const row = $(this);
      const priceCell = row.find("td:nth-child(5)"); // Assuming price is in 5th cell
      const quantityInput = row.find("td:nth-child(6) input"); // Assuming quantity is in 6th cell (input)

      if (priceCell.length && quantityInput.length) {
        // Extract the actual numerical value from the formatted price
        const priceText = priceCell.text().replace(/[^0-9.-]/g, ''); // Remove non-numeric characters (commas, etc.)
        const price = parseFloat(priceText);

        const quantity = parseInt(quantityInput.val()); // Get quantity value
        totalSum += price * quantity; // Add product total (price * quantity)
      }
    });

    const formattedTotal = numeral(totalSum).format('0,0.00'); // Example format (customizable)
    $('#total').text(formattedTotal);
  }

  function getTableData() {
    const user = $('#user_id').val();
    const parts = user.split('-');
    const id = parts[0];
    const userId = parts[0]; // Use .val() for input elements
    const customerName = $('#customerNameInput').val();
    const customerPhone = $('#customerPhoneInput').val();
    const total = parseFloat($('#total').text().replace(/[^0-9.-]/g, ''));
    const tableBody = $("#productImportTable tbody");
    const tableData = []; // Array to store product data

    tableBody.find("tr").each(function () {
      const row = $(this);
      const product = {}; // Object to store product details

      // Assuming product details are in the first few table cells:
      product.id = row.find("td:nth-child(1)").text(); // Get text from 1st cell (ID)
      product.productName = row.find("td:nth-child(2)").text(); // Get text from 2nd cell (Product Name)
      product.colorName = row.find("td:nth-child(3)").text(); // Get text from 3rd cell (Color)
      product.sizeName = row.find("td:nth-child(4)").text(); // Get text from 4th cell (Size)
      product.price = parseFloat(row.find("td:nth-child(5)").text().replace(/[^0-9.-]/g, '')); // Get text from 5th cell (Price)

      // Add quantity if present (assuming input in the 6th cell):
      const quantityInput = row.find("td:nth-child(6) input");
      if (quantityInput.length) {
        product.quantity = parseInt(quantityInput.val()); // Get value from quantity input
      }

      tableData.push(product); // Add product object to the data array
    });

    $.ajax({
      url: "<?= ROOT ?>AdminOrder/addNewOrder", // Replace with your server-side URL
      type: "POST", // Assuming POST request for sending data
      data: { userId: userId, customerName: customerName, customerPhone: customerPhone, total: total, invoiceDetail: JSON.stringify(tableData) }, // Convert data to JSON string
      success: function (data, status) {
        console.log(data);
        Swal.fire({
          icon: "success",
          title: "Thêm thành công",
          position: "center",
          confirmButtonColor: "#3459e6",
        }).then((result) => {
          window.location.href = "<?= ROOT ?>AdminOrder";
        });
      },

      error: function (error) {
        console.error("Error sending data:", error);
      }
    });
  }




  function getAllProductForSelect() {
    $.ajax({
      url: "<?= ROOT ?>AdminProduct/getAllProductForSelect",
      type: "post",
      success: function (data, status) {
        $('#products').html(data);
      }
    });
  }




  function getAllProductDetailByProductID(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminProductDetail/getAllProductDetailSale",
      type: "post",
      data: { product_id: id },
      success: function (data, status) {
        $('#productDetails').html(data);
      }
    });
  }
  $('#products').on("change", function () {
    var product_id = $(this).val();
    getAllProductDetailByProductID(product_id)
  });


  function getUserInCharge(id) {
    $.ajax({
      url: "<?= ROOT ?>AdminUser/getById",
      type: "post",
      data: { id: id },
      success: function (data, status) {
        console.log(JSON.parse(data));
        var userInCharge = JSON.parse(data);
        $('#user_id').val(userInCharge.id + " - " + userInCharge.fullname);
      }
    });
  }

  getUserInCharge(<?= $_SESSION['user_id'] ?>);





</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>