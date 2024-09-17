<?php $this->view("include/AdminHeader", $data) ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-4">
        <div class="col-sm-6 col-xl-4">
          <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-line fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Doanh thu trong ngày</p>
              <h6 class="mb-0"><?= currency_format($data['todayRevenue']) ?></h6>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-4">
          <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-bar fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Doanh thu tháng này</p>
              <h6 class="mb-0"><?= currency_format($data['thisMonthRevenue']) ?></h6>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-4">
          <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-pie fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Doanh thu trong năm</p>
              <h6 class="mb-0"><?= currency_format($data['thisYearRevenue']) ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Sale & Revenue End -->

    <!-- Chart Start -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
          <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Biểu đồ sản phẩm bán chạy</h6>
            <canvas id="pie-chart"></canvas>
          </div>
        </div>
        <div class="col-sm-12 col-xl-6">
          <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Sản phẩm bán chạy</h6>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Hình Ảnh</th>
                  <th scope="col">Sản Phẩm</th>
                  <th scope="col">Giá Bán</th>
                  <th scope="col">Số Lượng Bán Ra</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                  $topProducts = json_decode($data['topProducts'], true);
                  associative:
                  foreach ($topProducts as $product) {
                    ?>
                  <tr>
                    <td><img class="previewImage_table" src="<?= ASSETS . 'img/' . $product['image'] ?>" alt=""></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= currency_format($product['price']) ?></td>
                    <td><?= $product['total_sales'] ?></td>
                  </tr>
                <?php } ?>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Chart End -->


    <!-- Chart Start -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-4">
        <h5 class="mt-4 text-center">Doanh thu theo ngày</h5>
        <div class="col-xl-12 d-flex gap-2">
          <div class="flex-grow-1">
            <label class="form-label" for="">Từ ngày</label>
            <input id="startDate" name="startDate" class="form-control" type="date">
          </div>
          <div class="flex-grow-1">
            <label class="form-label" for="">Đến ngày</label>
            <input id="endDate" name="endDate" class="form-control" type="date">
          </div>
        </div>
        <div class="col-sm-12 col-xl-12">
          <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Multiple Bar Chart</h6>
            <canvas id="worldwide-sales"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Chart End -->
  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>

  var ctx5 = $("#pie-chart").get(0).getContext("2d");

  // Assuming `topProducts` is already a valid JSON array received from PHP
  var labels = [];
  var data = [];
  var topProducts = <?= json_encode(
    $topProducts
  ); ?>;
  console.log(topProducts);
  topProducts.forEach(function (product) {
    labels.push(product.name);
    data.push(product.total_sales);
  });

  var myChart5 = new Chart(ctx5, {
    type: "pie",
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: [
          "rgba(52, 89, 230, .7)",
          "rgba(52, 89, 230, .6)",
          "rgba(52, 89, 230, .5)",
          "rgba(52, 89, 230, .4)",
          "rgba(52, 89, 230, .3)"
        ]
      }]
    },
    options: {
      responsive: true
    }
  });


  $(document).ready(function () {
    $('#startDate, #endDate').on('change', function () {
      var startDate = $('#startDate').val();
      var endDate = $('#endDate').val();

      // Gọi hàm gửi AJAX
      getChartData(startDate, endDate);
    });

    function getChartData(startDate, endDate) {
      $.ajax({
        url: '<?= ROOT ?>AdminHome/getProfitByDate', // Đường dẫn đến file PHP xử lý dữ liệu
        method: 'POST',
        data: {
          startDate: startDate,
          endDate: endDate
        },
        success: function (response) {
          var chartData = JSON.parse(response);
          // console.log(chartData);
          // Use chartData for configuring the chart
          configureChart(chartData);
        }
      });
    }
  });

  function configureChart(chartData) {
    var ctx = $("#worldwide-sales").get(0).getContext("2d");
    var myChart = new Chart(ctx, {
      // Chart type configuration
      type: "bar", // Change to "bar" for bar chart

      // Chart data configuration
      data: {
        labels: [], // We'll populate this with labels from chartData
        datasets: [], // We'll populate this with datasets from chartData
      },

      // Optional chart options
      options: {
        responsive: true,
      },
    });

    // Loop through chartData to populate labels and datasets
    for (var i = 0; i < chartData.length; i++) {
      var row = chartData[i];
      console.log(row); // Check the content of each row
      myChart.data.labels.push(row.ngay);
      myChart.data.datasets.push({
        label: "Doanh Thu",
        data: [row.tong_doanh_thu],
        backgroundColor: "rgba(0, 156, 255, .5)",
        fill: true,
      });

      if (row.tong_chi_phi) {
        myChart.data.datasets.push({
          label: "Chi Phí",
          data: [row.tong_chi_phi],
          backgroundColor: "rgba(255, 99, 132, .5)",
          fill: true,
        });
      }

      if (row.loi_nhuan) {
        myChart.data.datasets.push({
          label: "Lợi Nhuận",
          data: [row.loi_nhuan],
          backgroundColor: "rgba(200, 99, 132, .5)",
          fill: true,
        });
      }
    }

    myChart.update(); // Update the chart after data population
  }
</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>