<?php
class AdminLogout extends Controller
{
  public function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user->logout();
  }
}