<?php $this->view("include/header", $data) ?>

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
  <div class="row px-xl-5">
    <div class="col-lg-5 pb-5">
      <div class='w-100'>
        <img id="productDetail_img" class='w-100' style="height: 500px; width : 500px; object-fit:cover;"
          src="<?php echo ASSETS . "img/" . $data['product_detail'][0]->image ?>" alt="">
      </div>
    </div>

    <div class="col-lg-7 pb-5">
      <h3 class="font-weight-semi-bold"><?= $data['product_detail'][0]->product_name ?></h3>
      <div class="d-flex mb-3">
        <div class="text-primary mr-2">
          <?= $data['product_detail'][0]->category_name ?> - <?= $data['product_detail'][0]->brand_name ?>
        </div>
      </div>
      <h3 class="font-weight-semi-bold mb-4"><?= currency_format($data['product_detail'][0]->price) ?></h3>


      <!-- Chọn màu -->
      <div class="d-flex mb-3">
        <form id="colors_chooser" class='mx-2 d-flex align-items-center gap-3'>

        </form>
      </div>

      <div class="d-flex mb-3">
        <form id="sizes_chooser" class='mx-2 d-flex align-items-center gap-3'>

        </form>
      </div>


      <div class="d-flex align-items-center mb-4 pt-2">
        <button onclick='addToCart()' class='btn btn-primary px-3 mx-2 w-50' style='height: 50px'><i
            class='fa fa-shopping-cart mr-1'></i> Thêm
          vào giỏ</button>

      </div>
    </div>
  </div>
  <div class="row px-xl-5">
    <div class="col">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-pane-1">
          <h4 class="mb-3 fw-bold">Mô tả sản phẩm</h4>
          <p><?= $data['product_detail'][0]->product_description ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Shop Detail End -->

<script>



  // thêm sản phẩm vào giỏ hàng
  function addToCart() {
    var sizeChoose = false;

    // kiểm tra khách hàng đã chọn kích cỡ chưa
    if ($('input[name="sizes"]:checked').length === 0) {
      Swal.fire({
        title: "Vui lòng chọn kích cỡ sản phẩm",
        position: 'center',
        showConfirmButton: true,
        confirmButtonColor: "#3459e6",
        icon: "error",
      });
      return;
    } else {
      sizeChoose = true;
    }
    if (sizeChoose) {
      var product_id = <?= $data['product_detail'][0]->product_id ?>;
      var colorChoosen = $('#colors_chooser').find('input[type="radio"]:checked');
      var colorId = colorChoosen.attr('id');
      var partsColor = colorId.split(" - ");
      var sizeChoosen = $('#sizes_chooser').find('input[type="radio"]:checked');
      var sizeId = sizeChoosen.attr('id');
      var partsSize = sizeId.split(" - ");

      <?php if (isset($_SESSION['user_id'])) { ?>
        var user_id = <?php echo $_SESSION['user_id']; ?>;
        $.ajax({
          url: "<?= ROOT ?>cart/addToCart",
          type: 'post',
          data: { user_id: user_id, product_id: product_id, color_id: partsColor[0], size_id: partsSize[0] },
          success: function (data, status) {
            Swal.fire({
              title: data,
              position: 'center',
              showConfirmButton: true,
              confirmButtonColor: "#3459e6",
              icon: "success",
            });
          }
        });
      <?php } else { ?>
        Swal.fire({
          title: "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng",
          position: 'center',
          showConfirmButton: true,
          confirmButtonColor: "#d33",
          icon: "error",
        });
      <?php } ?>
    }
  }

  // hiển thị màu sắc tương ứng cho sản phẩm
  function colors_chooser(product_id, color_id) {
    $.ajax({
      url: "<?= ROOT ?>color/getAllColor",
      type: 'post',
      data: { product_id: product_id, color_id: color_id },
      success: function (data, status) {
        $('#colors_chooser').html(data);
      }
    });
  }

  // hiển thị kích cỡ tương ứng với màu sắc của sản phẩm
  function sizes_chooser(product_id, color_id) {
    $.ajax({
      url: "<?= ROOT ?>shop/getAllSizeByColor",
      type: 'post',
      data: { product_id: product_id, color_id: color_id },
      success: function (data, status) {
        $('#sizes_chooser').html(data);
      }
    });
  }

  // thực hiện khi load lại trang
  $(document).ready(function () {
    colors_chooser(<?= $data['product_detail'][0]->product_id ?>, <?= $data['product_detail'][0]->color_id ?>);
    sizes_chooser(<?= $data['product_detail'][0]->product_id ?>, <?= $data['product_detail'][0]->color_id ?>);

  })

  // khi lựa chọn các kích cỡ của sản phẩm thay đổi theo màu sắc được chọn
  $('#colors_chooser').on("change", function () {
    var colorChoosen = $(this).find('input[type="radio"]:checked');
    var colorId = colorChoosen.attr('id');
    var parts = colorId.split(" - ");
    var product_id = <?= $data['product_detail'][0]->product_id ?>;
    $.ajax({
      url: "<?= ROOT ?>shop/getProductDetailByColor",
      type: 'post',
      data: { product_id: product_id, color_id: parts[0] },
      success: function (data, status) {
        var productDetail = JSON.parse(data);
        $('#productDetail_img').attr('src', "<?= ASSETS ?>" + "img/" + productDetail.image); // Replace "image_url" with actual property name
      }
    });

    $.ajax({
      url: "<?= ROOT ?>shop/getAllSizeByColor",
      type: 'post',
      data: { product_id: product_id, color_id: parts[0] },
      success: function (data, status) {
        $('#sizes_chooser').html(data);
      }
    });
  })

</script>
<?php $this->view("include/footer") ?>