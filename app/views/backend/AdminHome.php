<?php $this->view("include/AdminHeader", $data) ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>

<div class="container-xxl position-relative bg-white d-flex p-0">
  <?php $this->view("include/AdminSidebar", $data) ?>
  <!-- Content Start -->
  <div class="content">
    <?php $this->view("include/AdminNavbar", $data) ?>

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4" id="displayShow">
        
    </div>
    <br>
    <!-- Sale & Revenue End -->

    <div class="bg-light text-center rounded p-4">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">Doanh thu &amp; Lợi nhuận</h6>
      </div>
      <canvas id="salse-revenue" style="display: block; box-sizing: border-box; height: 412px; width: 825.6px;" width="1032" height="515"></canvas>
    </div>
  </div>
  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<script>
  
  $(document).ready(function () {
    statsDiagram();
  });

  function statsDiagram(page) {
    $.ajax({
      url: "<?= ROOT ?>AdminHome/getStats",
      type: 'POST',
      data: {
        page: page
      },
      success: function (data, status) {
        $('#displayShow').html(data);
      }
    });
  }

  function chart(){
 var ctx = $('#salse-revenue').get(0).getContext('2d');
        console.log(<?=$data['chart']->year?>);
    var myChart = new Chart(ctx, {
      type: "line",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                    label: "doanh thu",
                    data: [15, 30, 55, 45, 70, 65, 85],
                    backgroundColor: "rgba(0, 156, 255, .5)",
                    fill: true
                },
                {
                    label: "lợi nhuận",
                    data: [99, 135, 170, 130, 190, 180,500],
                    backgroundColor: "rgba(0, 156, 255, .3)",
                    fill: true
                }
            ]
            },
        options: {
            responsive: true
        }
    });
  }
  chart();
</script>

<!-- Content End -->
<?php $this->view("include/AdminFooter", $data) ?>