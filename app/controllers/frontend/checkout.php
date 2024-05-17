<?php
class Checkout extends Controller
{
  function index($user_id)
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
      $data['page_title'] = "Check Out";
      $cart = $this->model("frontend/CartModel");
      $data['cart_data'] = $cart->getCartDataToCheckout($user_id);
      $this->view("frontend/checkout", $data);
    } else {
      $data['page_title'] = "Home";
      $this->view("frontend/home", $data);
    }
  }

  function place_order()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $order = $this->model("frontend/OrderModel");
      $order->insert($_POST);
      $order_id = $order->getLastestOrder($_POST);
      $order_detail = $this->model("frontend/OrderDetailModel");
      $order_detail_data = json_decode($_POST['order_detail'], true); // Chuyển chuỗi JSON thành mảng

      // Lặp qua từng dữ liệu trong mảng order_detail_data và thêm vào cơ sở dữ liệu
      foreach ($order_detail_data['cartData'] as $item) {
        $product_detail_id = $item['product_detail_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $subtotal = $price * $quantity;
        $order_detail->insert($order_id->id, $product_detail_id, $quantity, $subtotal);
      }

      // Lấy mã giỏ hàng của khách hàng hiện tại
      $cart = $this->model("frontend/CartModel");
      $cart_id = $cart->getCartIDByUserID($_POST);
      // Xoá chi tiết giỏ hàng dựa vào mã giỏ hàng ở trên
      $cart_detail = $this->model("frontend/CartDetailModel");
      $cart_detail->deleteByCartId($cart_id);
      // Xoá giỏ hàng
      $cart->delete($cart_id);
    }
  }
}