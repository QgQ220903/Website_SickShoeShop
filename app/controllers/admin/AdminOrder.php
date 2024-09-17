<?php

class AdminOrder extends Controller
{
  // trang chính quản lý hoá đơn
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Order";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminOrder", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }


  function addOrder()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Add New Order";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminAddOrder", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function addNewOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $invoice = $this->model("admin/AdminOrderModel");
      $invoice->insert($_POST);
      $latestInvoice = $invoice->getLatestInvoice();

      $productData = json_decode($_POST['invoiceDetail'], true);

      if ($productData) {
        $invoiceDetail = $this->model("admin/AdminOrderDetailModel");
        $productDetail = $this->model("admin/AdminProductDetailModel");
        foreach ($productData as $product) {
          // Extract product details
          $id = $product['id'];
          $productName = $product['productName'];
          $colorName = $product['colorName'];
          $sizeName = $product['sizeName'];
          $price = $product['price'];
          $quantity = $product['quantity'];
          $subtotal = $price * $quantity;
          $invoiceDetail->insert($latestInvoice->id, $id, $quantity, $subtotal);
          $productDetail->decreaseQuantity($id, $quantity);
        }
      }
    }
  }



  // lấy toàn bộ hoá đơn
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("admin/AdminOrderModel");
      $Order->getAll();
    }
  }

  // lấy ra toàn bộ hoá đơn không phân trang
  function getAllOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("admin/AdminOrderModel");
      $Order->getAllOrder();
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $Order = $this->model("admin/AdminOrderModel");
      $Order->search($keyword);
    }
  }

  // kiểm tra trùng lặp
  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("admin/AdminOrderModel");
      $Order->checkDuplicate($_POST);
    }
  }
  // thêm mới 1 hoá đơn
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("admin/AdminOrderModel");
      $Order->insert($_POST);
    }
  }

  // xóa 1 hoá đơn
  function delete()
  {
    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $Order = $this->model("admin/AdminOrderModel");
      $Order->delete($id);
    }
  }

  // lấy ra hoá đơn qua id
  function getByID($id)
  {
    $Order = $this->model("admin/AdminOrderModel");
    if (isset($_POST['id'])) {
      $Order_id = $_POST['id'];
      $Order->getByID($Order_id);
    }
  }

  function getDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $orders = $this->model('admin/AdminOrderModel');
      $orders->getDetail($_POST);

    }
  }

  // cập nhật hoá đơn
  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $Order = $this->model("admin/AdminOrderModel");
      $Order->update($_POST);
    }
  }
  function updateOrderStatus($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $order = $this->model("admin/AdminOrderModel");
      $order->updateOrderStatus($_POST);
    }
  }

}