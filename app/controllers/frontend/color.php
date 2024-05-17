<?php

class Color extends Controller
{


  function getAllColor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $color = $this->model("frontend/ColorModel");
      $color->colors_chooser($_POST['product_id'], $_POST['color_id']);
    }
  }

}