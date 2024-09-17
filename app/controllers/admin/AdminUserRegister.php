<?php
class AdminUserRegister extends Controller
{
  function index()
  {
    $model = $this->model("backend/AdminUserModel");
    $user_data = $model->check_login();
    $data['user_data'] = $user_data;
    $data['page_title'] = "Admin - Register";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $model->register($_POST);
    }
    $this->view("backend/AdminUserRegister", $data);
  }
}
?>