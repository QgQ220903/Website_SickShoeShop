<?php
class Controller
{
  public function view($view, $data = [])
  {
    if (file_exists("./app/views/" . $view . ".php")) {
      include "./app/views/" . $view . ".php";
    } else {
      include "./app/views/frontend/404.php";
    }
  }

  public function model($path)
  {
    if (file_exists("./app/models/" . $path . ".php")) {
      include "./app/models/" . $path . ".php";
      $parts = explode('/', $path);
      $model = end($parts);
      return new $model;
    }
    return false;
  }

}
?>