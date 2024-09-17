<?php
class AdminModule extends Controller
{
  function index()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $module = $this->model('backend/AdminModuleModel');
      $module->getAllModule();
    }
  }
  function getAllModule()
  {
 
  }
}