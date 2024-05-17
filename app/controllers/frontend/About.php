<?php

class About extends Controller
{
  function index()
  {
    $user = $this->model("frontend/user");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['user_data'] = $user_data;
    }
    $data['page_title'] = "About";
    $this->view("frontend/About", $data);
  }


}