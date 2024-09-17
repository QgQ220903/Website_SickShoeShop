<?php
class AdminLogout extends Controller
{
  public function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user->logout();
  }
}