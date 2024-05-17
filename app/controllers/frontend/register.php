<?php

class Register extends Controller
{
  function index()
  {
    $data['page_title'] = "Đăng Ký";
    $this->view("frontend/register", $data);
  }

  function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("frontend/user");
      $user->register($_POST);
    }
  }
}