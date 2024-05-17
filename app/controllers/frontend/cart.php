<?php

class Cart extends Controller
{
  function index()
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
      $data['page_title'] = "Cart";
      $this->view("frontend/cart", $data);
    } else {
      $data['page_title'] = "Home";
      $this->view("frontend/home", $data);

    }

  }
  function getCartByUserID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $cart = $this->model("frontend/CartModel");
      $cart->getCartByUserID($_POST);
    }
  }

  function addToCart()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $cart = $this->model("frontend/CartModel");
      // lấy ra cart_id từ user_id
      $cart_id = $cart->getCartIDByUserID($_POST);
      // kiểm tra user đã tồn tại cart chưa
      if ($cart_id == 0) {
        // nếu chưa thì thực hiện thêm mới cart 
        $cart->insert($_POST);
        // sau đó lấy ra cart id vừa thêm vào
        $cart_id = $cart->getCartIDByUserID($_POST);
      }
      // lấy ra mã sản phẩm / màu sắc / kích cỡ
      $product_id = $_POST['product_id'];
      $color_id = $_POST['color_id'];
      $size_id = $_POST['size_id'];
      $product_detail = $this->model("frontend/product_detail");
      // từ mã sản phẩm / màu sắc / kích cỡ lấy ra mã chi tiết sản phẩm
      $product_detail_choose = $product_detail->getProductDetailByProductIDColorIDSizeID($product_id, $color_id, $size_id);
      $cart_detail = $this->model("frontend/CartDetailModel");
      $cart_detail->insert($cart_id, $product_detail_choose[0]->id);
      $product_detail->updateQuantity($product_detail_choose[0]->id);
    }
  }


}