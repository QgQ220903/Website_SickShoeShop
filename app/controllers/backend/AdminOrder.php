<?php

class AdminOrder extends Controller
{
  // trang chính quản lý hoá đơn
  function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Order";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminOrder", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }


  // lấy toàn bộ hoá đơn
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("backend/AdminOrderModel");
      $Order->getAll();
    }
  }

  // lấy ra toàn bộ hoá đơn không phân trang
  function getAllOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("backend/AdminOrderModel");
      $Order->getAllOrder();
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $Order = $this->model("backend/AdminOrderModel");
      $Order->search($keyword);
    }
  }

  // kiểm tra trùng lặp
  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("backend/AdminOrderModel");
      $Order->checkDuplicate($_POST);
    }
  }
  // thêm mới 1 hoá đơn
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("backend/AdminOrderModel");
      $Order->insert($_POST);
    }
  }

  // xóa 1 hoá đơn
  function delete()
  {
    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $Order = $this->model("backend/AdminOrderModel");
      $Order->delete($id);
    }
  }

  // lấy ra hoá đơn qua id
  function getByID($id)
  {
    $Order = $this->model("backend/AdminOrderModel");
    if (isset($_POST['id'])) {
      $Order_id = $_POST['id'];
      $Order->getByID($Order_id);
    }
  }

  // cập nhật hoá đơn
  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("backend/AdminOrderModel");
      $Order->update($_POST);
    }
  }
  function updateOrderStatus($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $order = $this->model("backend/AdminOrderModel");
      $order->updateOrderStatus($_POST);
    }
  }

}