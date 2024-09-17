<?php

class AdminHome extends Controller
{
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['modules'] = $user->check_role($user_data->role_id);
      $data['page_title'] = "Admin - Home";
      $data['user_data'] = $user_data;
      $statisticModel = $this->model("admin/AdminStatisticModel");
      // Gọi hàm trong model và lưu kết quả
      $data['topProducts'] = $statisticModel->getTopSaleProduct(5);

      // Lấy năm, tháng, ngày hiện tại
      $year = date('Y');
      $month = date('m');
      $date = date('Y-m-d');
      // Gọi hàm tính doanh thu với các giá trị vừa lấy
      $thisMonthRevenue = $statisticModel->monthlyRevenue($year, $month);
      $thisYearRevenue = $statisticModel->yearlyRevenue($year);

      $data['todayRevenue'] = $statisticModel->dailyRevenue();
      $data['thisMonthRevenue'] = $thisMonthRevenue;
      $data['thisYearRevenue'] = $thisYearRevenue;

      $this->view("admin/AdminHome", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function getProfitByDate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $startDate = $_POST['startDate'];
      $endDate = $_POST['endDate'];
      $statisticModel = $this->model("admin/AdminStatisticModel");
      $statisticModel->getProfitByDate($startDate, $endDate);
    }
  }


}