<?php
class Ward extends Controller
{
  function index()
  {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
      $ward = $this->model("admin/WardModel");
      $ward->getAllWard($_POST);
    }
  }

  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
      $ward = $this->model("admin/WardModel");
      $ward->getAllWards($_POST);
    }
  }
}