<?php

class AdminSize extends Controller
{
  // hiển thị chính của quản lý kích cỡ
  function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Size";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminSize", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  // lấy toàn bộ bản ghi bảng kích cỡ
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $size = $this->model("backend/AdminSizeModel");
      $size->getAll();
    }
  }

  // lấy ra toàn bộ kích cỡ không phân trang
  function getAllSize()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $size = $this->model("backend/AdminSizeModel");
      $size->getAllSize();
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $size = $this->model("backend/AdminSizeModel");
      $size->search($keyword);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $size = $this->model("backend/AdminSizeModel");
      $size->insert($_POST);
    }
  }

  // kiểm tra trùng lặp
  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $size = $this->model("backend/AdminSizeModel");
      $size->checkDuplicate($_POST);
    }
  }


  function delete()
  {

    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $size = $this->model("backend/AdminSizeModel");
      $size->delete($id);
    }
  }

  function getByID($id)
  {
    $size = $this->model("backend/AdminSizeModel");
    if (isset($_POST['id'])) {
      $size_id = $_POST['id'];
      $size->getByID($size_id);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $size = $this->model("backend/AdminSizeModel");
      $size->update($_POST);
    }
  }
}