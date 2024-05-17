<?php

class CartDetail extends Controller
{
  public function deleteCartDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $cartDetail = $this->model("frontend/CartDetailModel");
      $cartDetail->delete($_POST);
    }
  }
}