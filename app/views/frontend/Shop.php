<?php $this->view("include/header", $data) ?>

<!-- MAIN CONTENT -->
<!-- Shop Start -->
<div class="container-fluid pt-5">

  <div class="row px-xl-5">
    <!-- Shop Sidebar Start -->
    <div class="col-lg-3 col-md-12">
      <!-- search Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Tìm kiếm theo tên</h5>
        <form class="row">
          <input type="text" class="form-control" id="search">
        </form>
      </div>
      <!-- search End -->

      <!-- Price Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Lọc theo giá tiền</h5>
        <form class="row">
          <div
            class="col-lg-6 custom-control custom-checkbox d-flex align-items-center gap-2 justify-content-between mb-3">
            <input type="text" class="form-control" checked id="min_price" placeholder="Từ giá"
              onchange="callFetchPage()">
          </div>
          <div
            class="col-lg-6 custom-control custom-checkbox d-flex align-items-center gap-2 justify-content-between mb-3">
            <input type="text" class="form-control" checked id="max_price" placeholder="Đến giá"
              onchange="callFetchPage()">
          </div>
        </form>
      </div>
      <!-- Price End -->

      <!-- category Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Lọc theo thể loại</h5>
        <form id="category-form">
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" name="Tất cả" checked id="category-all"
                onclick="callFetchPage('category')">
            </div>
            <label class="custom-control-label" for="category-all">Tất cả</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="category-1" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="category-1">Giày nam</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="category-2" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="category-2">Giày nữ</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="category-3" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="category-3">Giày thể thao nam</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="category-4" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="category-4">Giày thể thao nữ</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="category-5" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="category-5">Giày nam - nữ</label>
          </div>

        </form>
      </div>
      <!-- category End -->

      <!-- brand Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Lọc theo thương hiệu</h5>
        <form id="brand-form">
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" checked id="brand-all" onclick="callFetchPage('brand')">
            </div>
            <label class="custom-control-label" for="brand-all">Tất cả</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="brand-1" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="brand-1">Nike</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="brand-2" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="brand-2">Puma</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="brand-3" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="brand-3">Adidas</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="brand-4" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="brand-4">Vans</label>
          </div>


        </form>
      </div>
      <!-- category End -->

      <!-- color Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Lọc theo màu sắc</h5>
        <form id="color-form">
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" checked id="color-all" onclick="callFetchPage('color')">
            </div>
            <label class="custom-control-label" for="color-all">Tất cả</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="color-1" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="color-1">Đen</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="color-2" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="color-2">Trắng</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="color-3" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="color-3">Xanh dương</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="color-4" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="color-4">Đỏ</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="color-5" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="color-5">Cam</label>
          </div>
        </form>
      </div>
      <!-- color End -->
      <!-- color Start -->
      <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Lọc theo kích cỡ</h5>
        <form id="size-form">
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" checked id="size-all" onclick="callFetchPage('size')">
            </div>
            <label class="custom-control-label" for="size-all">Tất cả</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="size-1" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="size-1">38</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="size-2" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="size-2">39</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="size-3" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="size-3">40</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3 mb-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="size-4" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="size-4">41</label>
          </div>
          <div class="custom-control custom-checkbox d-flex align-items-center gap-3">
            <div class="checkbox-wrapper-2">
              <input type="checkbox" class="sc-gJwTLC ikxBAC" id="size-5" onclick="callFetchPage()">
            </div>
            <label class="custom-control-label" for="size-5">42</label>
          </div>

        </form>
      </div>
      <!-- color End -->


    </div>
    <!-- Shop Sidebar End -->


    <!-- Shop Product Start -->
    <div id="products" class="col-lg-9 col-md-12">

    </div>
    <!-- Shop Product End -->
  </div>

</div>
<!-- Shop End -->
<!-- END MAIN -->

<?php $this->view("include/footer") ?>

<script>

  function fetch_data(page, keyword, mingia, maxgia, category, brand, color, size) {
    if (mingia != null) {
      var category = encodeURIComponent(category);
      var brand = encodeURIComponent(brand);
      var color = encodeURIComponent(color);
      $.ajax({
        url: "<?= ROOT ?>shop/getProductForShop",
        type: 'post',
        data: {
          page: page,
          keyword: keyword,
          minPrice: mingia,
          maxPrice: maxgia,
          category: category,
          brand: brand,
          color: color,
          size: size
        },
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        success: function (data, status) {
          $('#products').html(data);
        }
      });
    } else {
      $.ajax({
        url: "<?= ROOT ?>shop/getProductForShop",
        type: 'post',
        data: {
          page: page,
          keyword: keyword
        },
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        success: function (data, status) {
          $('#products').html(data);
        }
      });
    }

  }

  // hàm khi nhấn vào số trang để đối trang
  function changePageFetch(page, keyword) {
    fetch_data(page, keyword);
  }

  // khi vừa vào shop sẽ gọi ajax để lấy ra các sản phẩm cho khách hàng mua hàng
  $(document).ready(function () {
    fetch_data();
  })


  function categoryFilter() {

  }

  $('#min_price, #max_price, #search').on('keyup', function () {
    callFetchPage();
  });

  function callFetchPage(all) {

    //Lấy từ khóa search
    var searchText = $('#search').val();

    //Kiểm tra giá
    var minPrice = $('#min_price').val();
    var maxPrice = $('#max_price').val();
    if (minPrice != "" && maxPrice && minPrice >= maxPrice) {
      return;
    }

    //Kiểm tra thể loại
    if (all == "category") {
      $('#category-1, #category-2,#category-3,#category-4,#category-5').prop('checked', false);
    } else {
      if ($('#category-1, #category-2,#category-3,#category-4,#category-5').is(':checked')) {
        $('#category-all').prop('checked', false);
      }
    }
    //Kiểm tra thương hiệu
    if (all == "brand") {
      $('#brand-1, #brand-2,#brand-3,#brand-4').prop('checked', false);
    } else {
      if ($('#brand-1, #brand-2,#brand-3,#brand-4').is(':checked')) {
        $('#brand-all').prop('checked', false);
      }
    }

    //kiểm tra màu sắc
    if (all == "color") {
      $('#color-1, #color-2,#color-3,#color-4,#color-5').prop('checked', false);
    } else {
      if ($('#color-1, #color-2,#color-3,#color-4,#color-5').is(':checked')) {
        $('#color-all').prop('checked', false);
      }
    }
    //kiểm tra size 
    if (all == "size") {
      $('#size-1, #size-2,#size-3,#size-4,#size-5').prop('checked', false);
    } else {
      if ($('#size-1, #size-2,#size-3,#size-4,#size-5').is(':checked')) {
        $('#size-all').prop('checked', false);
      }
    }

    //Lấy dữ liệu category
    var category = '';

    // Lặp qua các checkbox đã được chọn trong form nhất định bằng jQuery
    $('#category-form input[type="checkbox"]:checked').each(function () {
      // Lấy id của checkbox
      let checkboxId = $(this).attr('id');

      // Truy xuất đối tượng nhãn (label) đi kèm với checkbox bằng id
      let label = $('label[for="' + checkboxId + '"]');

      // Kiểm tra nếu nhãn (label) tồn tại
      if (label.length > 0 && label.text() !== 'Tất cả') {
        category += label.text().trim() + ',';
      }
    });

    //Lấy dữ liệu brand
    var brand = '';

    // Lặp qua các checkbox đã được chọn trong form nhất định bằng jQuery
    $('#brand-form input[type="checkbox"]:checked').each(function () {
      // Lấy id của checkbox
      let checkboxId = $(this).attr('id');

      // Truy xuất đối tượng nhãn (label) đi kèm với checkbox bằng id
      let label = $('label[for="' + checkboxId + '"]');

      // Kiểm tra nếu nhãn (label) tồn tại
      if (label.length > 0 && label.text() !== 'Tất cả') {
        brand += label.text().trim() + ',';
      }
    });

    //Lấy dữ liệu color
    var color = '';

    // Lặp qua các checkbox đã được chọn trong form nhất định bằng jQuery
    $('#color-form input[type="checkbox"]:checked').each(function () {
      // Lấy id của checkbox
      let checkboxId = $(this).attr('id');

      // Truy xuất đối tượng nhãn (label) đi kèm với checkbox bằng id
      let label = $('label[for="' + checkboxId + '"]');

      // Kiểm tra nếu nhãn (label) tồn tại
      if (label.length > 0 && label.text() !== 'Tất cả') {
        color += label.text().trim() + ',';
      }
    });

    //Lấy dữ liệu size
    var size = '';

    // Lặp qua các checkbox đã được chọn trong form nhất định bằng jQuery
    $('#size-form input[type="checkbox"]:checked').each(function () {
      // Lấy id của checkbox
      let checkboxId = $(this).attr('id');

      // Truy xuất đối tượng nhãn (label) đi kèm với checkbox bằng id
      let label = $('label[for="' + checkboxId + '"]');

      // Kiểm tra nếu nhãn (label) tồn tại
      if (label.length > 0 && label.text() !== 'Tất cả') {
        size += label.text().trim() + ',';
      }
    });

    category = category.replace(/,\s*$/, '');
    brand = brand.replace(/,\s*$/, '');
    color = color.replace(/,\s*$/, '');
    size = size.replace(/,\s*$/, '');
    // alert(category + '\n' + brand+ '\n' + color + '\n' + size)

    fetch_data(1, searchText, minPrice, maxPrice, category, brand, color, size);
  }

</script>