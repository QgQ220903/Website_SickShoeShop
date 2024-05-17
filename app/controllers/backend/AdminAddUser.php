<?php
class AdminAddUser extends Controller
{
  function index()
  {

    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Thêm người dùng";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminAddUser", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  function update($id)
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Sửa người dùng";
      $data['user_data'] = $user_data;

      $user_update = $user->getByID($id);
      $data['user_update'] = $user_update;

      $this->view("backend/AdminAddUser", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  function detail($id)
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - người dùng";
      $data['user_data'] = $user_data;
      $data['detail'] = true;

      $user_update = $user->getByID($id);
      $data['user_update'] = $user_update;

      $this->view("backend/AdminAddUser", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }
}
?>