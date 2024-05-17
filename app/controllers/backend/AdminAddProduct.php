<?php
class AdminAddProduct extends Controller
{
  function index()
  {

    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Add Product";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminAddProduct", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }
}
?>