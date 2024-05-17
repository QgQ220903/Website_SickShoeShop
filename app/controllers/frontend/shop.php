<?php

class Shop extends Controller
{

  function index()
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
    }
    $data['page_title'] = "Shop";
    $this->view("frontend/shop", $data);
  }

  // lấy ra đại diện các sản phẩm theo màu sắc cho khách hàng lựa chọn
  function getProductForShop()
  {
    $product = $this->model("frontend/product_detail");
    $product->getProductForShop();
  }

  // lấy ra 1 chi tiết sản phẩm bằng mã sản phẩm và mã màu sắc
  function getProductDetailByColor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("frontend/product_detail");
      $product->getProductDetailByColor($_POST['product_id'], $_POST['color_id']);
    }
  }

  // lấy ra các biến thể kích cỡ của 1 sản phẩm dựa trên màu sắc
  function getAllSizeByColor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("frontend/product_detail");
      $product->getAllSizeByColor($_POST['product_id'], $_POST['color_id']);
    }
  }

  // hiển thị ra chi tiết của 1 sản phẩm
  function showProductDetail($productDetailID)
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    $data['page_title'] = "Product - Detail";
    $product = $this->model("frontend/product_detail");
    $data['product_detail'] = $product->showProductDetail($productDetailID);
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
      $this->view("frontend/product_detail", $data);
    } else {
      $this->view("frontend/product_detail", $data);
    }
  }

  function productDetail($product_id, $color_id, $size_id)
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    $data['page_title'] = "Product - Detail";
    $product = $this->model("frontend/product_detail");
    $data['products'] = $product->getAllProductDetailByProductID($product_id, $color_id, $size_id);
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
      $this->view("frontend/product_detail", $data);
    } else {
      $this->view("frontend/product_detail", $data);
    }
  }

  function getAllColorByProductID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product_detail = $this->model("frontend/product_detail");
      $product_id = $_POST['product_id'];
      $color_id = $_POST['color_id'];
      $product_detail->getAllColorByProductID($product_id, $color_id);
    }

  }


}



