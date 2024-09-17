<?php

class AdminSupplier extends Controller
{
  // trang chính quản lý 
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Supplier";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminSupplier", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  // lấy toàn bộ bản ghi bảng nhà cung cấp
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->getAll();
    }
  }

  function getAllSuppliers()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      if (isset($_POST['supplier_id'])) {
        $supplier->getAllSuppliers($_POST['supplier_id']);
      } else {
        $supplier->getAllSuppliers(0);
      }
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->search($keyword);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->insert($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->update($_POST);
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->checkDuplicate($_POST);
    }
  }
  function checkDuplicateUpdate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->checkDuplicateUpdate($_POST);
    }
  }

  function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->delete($_POST);
    }
  }

  function getByID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $supplier = $this->model("admin/AdminSupplierModel");
      $supplier->getByID($_POST['id']);
    }
  }

  function insertSupplierAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $address = $this->model("admin/AdminAddressModel");
      $address->insertSupplierAddress($_POST);
    }
  }
}