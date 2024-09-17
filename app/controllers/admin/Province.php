<?php
class Province extends Controller
{
  function index()
  {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
      $province = $this->model("admin/ProvinceModel");
      $province->getAllProvinces();
    }
  }
}