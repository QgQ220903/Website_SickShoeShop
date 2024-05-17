<?php

class Login extends Controller
{
  function index()
  {
    $data['page_title'] = "Đăng Nhập";
    $this->view("frontend/login", $data);
  }

  function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("frontend/user");
      $user->login($_POST);
    }
  }
}