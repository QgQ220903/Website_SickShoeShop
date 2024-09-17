<?php
class AdminProductDetail extends Controller
{
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product Detail";
      $data['user_data'] = $user_data;

      $this->view("admin/AdminProductDetail", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->insert($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->update($_POST);
    }
  }

  function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->delete($_POST['id']);
    }
  }

  function getAllProductDetail()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->getAllProductDetailByProductID($_POST['product_id']);
    }
  }

  function getAllProductDetailImport()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->getAllProductDetailByProductIDImport($_POST['product_id']);
    }
  }

  function getAllProductDetailSale()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->getAllProductDetailByProductIDSale($_POST['product_id']);
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $product_detail->checkDuplicate($_POST);
    }
  }

  function getProductDetailByID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("admin/AdminProductDetailModel");
      $id = $_POST['id'];
      $product_detail->getProductDetailByID($id);
    }
  }


}