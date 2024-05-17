<?php
class AdminProductImport extends Controller
{
  function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product Import";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminProductImport", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }
  function productImportForm()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product Import Form";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminProductImportForm", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $invoice = $this->model("backend/AdminInvoiceModel");
      $invoice->insert($_POST);
      $latestInvoice = $invoice->getLatestInvoice();

      $productData = json_decode($_POST['invoiceDetail'], true);

      if ($productData) {
        $invoiceDetail = $this->model("backend/AdminInvoiceDetailModel");
        $productDetail = $this->model("backend/AdminProductDetailModel");
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
          $productDetail->updateQuantity($id, $quantity);
        }
      }
    }
  }

  function getAllInvoices()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $invoice = $this->model("backend/AdminInvoiceModel");
      $invoice->getAllInvoices();
    }
  }

  function getInvoiceFormByID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $invoice = $this->model("backend/AdminInvoiceModel");
      $invoice->getInvoiceFormByID($_POST);
    }
  }
}