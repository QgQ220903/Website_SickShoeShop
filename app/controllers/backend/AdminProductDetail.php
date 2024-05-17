<?php
class AdminProductDetail extends Controller
{
  function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product Detail";
      $data['user_data'] = $user_data;

      $this->view("backend/AdminProductDetail", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->insert($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->update($_POST);
    }
  }

  function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->delete($_POST['id']);
    }
  }

  function getAllProductDetail()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->getAllProductDetailByProductID($_POST['product_id']);
    }
  }

  function getAllProductDetailImport()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->getAllProductDetailByProductIDImport($_POST['product_id']);
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $product_detail->checkDuplicate($_POST);
    }
  }

  function getProductDetailByID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("backend/AdminProductDetailModel");
      $id = $_POST['id'];
      $product_detail->getProductDetailByID($id);
    }
  }


}