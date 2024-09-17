<?php
class AdminLogin extends Controller
{
  function index()
  {
    $data['page_title'] = "Admin - Login";
    $this->view("admin/AdminLogin", $data);
  }

  function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      $user->login($_POST);
    }

  }
}

?>