<?php

class Order extends Controller
{
  function index()
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
      $data['page_title'] = "Order";
      $this->view("frontend/order", $data);
    }

  }

  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $orders = $this->model('frontend/OrderModel');
      $orders->GetAll($_POST);

    }
  }

  function getDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $orders = $this->model('frontend/OrderModel');
      $orders->getDetail($_POST);

    }
  }
}