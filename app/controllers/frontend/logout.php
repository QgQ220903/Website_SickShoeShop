<?php
class Logout extends Controller
{
  public function logout()
  {
    if (isset ($_POST['action'])) {
      $user = $this->model("frontend/user");
      $user->logout();
    }
  }
}