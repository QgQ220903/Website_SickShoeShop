<?php
class Ward extends Controller
{
  function index()
  {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
      $ward = $this->model("backend/WardModel");
      $ward->getAllWard($_POST);
    }
  }

  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
      $ward = $this->model("backend/WardModel");
      $ward->getAllWards($_POST);
    }
  }
}