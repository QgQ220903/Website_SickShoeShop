<?php

class AdminColor extends Controller
{
  // trang chính quản lý màu sắc
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Color";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminColor", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }


  // lấy toàn bộ màu sắc
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("admin/AdminColorModel");
      $color->getAll();
    }
  }

  // lấy ra toàn bộ màu sắc không phân trang
  function getAllColor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("admin/AdminColorModel");
      $color->getAllColor();
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $color = $this->model("admin/AdminColorModel");
      $color->search($keyword);
    }
  }

  // kiểm tra trùng lặp
  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("admin/AdminColorModel");
      $color->checkDuplicate($_POST);
    }
  }
  // thêm mới 1 màu sắc
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("admin/AdminColorModel");
      $color->insert($_POST);
    }
  }

  // xóa 1 màu sắc
  function delete()
  {
    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $color = $this->model("admin/AdminColorModel");
      $color->delete($id);
    }
  }

  // lấy ra màu sắc qua id
  function getByID($id)
  {
    $color = $this->model("admin/AdminColorModel");
    if (isset($_POST['id'])) {
      $color_id = $_POST['id'];
      $color->getByID($color_id);
    }
  }

  // cập nhật màu sắc
  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("admin/AdminColorModel");
      $color->update($_POST);
    }
  }
}