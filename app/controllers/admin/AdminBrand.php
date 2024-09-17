<?php

class AdminBrand extends Controller
{
  // trang chính quản lý thương hiệu
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Brand";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminBrand", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  // thêm mới 1 thương hiệu
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $brand = $this->model("admin/AdminBrandModel");
      $brand->insert($_POST);
    }
  }

  // kiểm tra trùng lặp
  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $brand = $this->model("admin/AdminBrandModel");
      $brand->checkDuplicate($_POST);
    }
  }

  // lấy toàn bộ bản ghi bảng thương hiệu
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $brand = $this->model("admin/AdminBrandModel");
      $brand->getAll();
    }
  }

  function getAllBrands()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $brand = $this->model('admin/AdminBrandModel');
      if (isset($_POST['brand_id'])) {
        $brand->getAllBrands($_POST['brand_id']);
      } else {
        $brand->getAllBrands(0);
      }
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $brand = $this->model("admin/AdminBrandModel");
      $brand->search($keyword);
    }
  }

  // xóa 1 thương hiệu
  function delete()
  {

    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $brand = $this->model("admin/AdminBrandModel");
      $brand->delete($id);
    }
  }

  // lấy thương hiệu thông qua id
  function getByID($id)
  {
    $brand = $this->model("admin/AdminBrandModel");
    if (isset($_POST['id'])) {
      $brand_id = $_POST['id'];
      $brand->getByID($brand_id);
    }
  }

  // cập nhật thương hiệu
  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $brand = $this->model("admin/AdminBrandModel");
      $brand->update($_POST);
    }
  }
}