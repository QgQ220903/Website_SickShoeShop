<?php
class AdminRoleDetail extends Controller
{
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      show($_POST);
    }
  }
}