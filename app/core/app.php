<?php
class App
{
  protected $controller = "home";
  protected $action = "index";
  protected $params = [];

  public function __construct()
  {
    $url = $this->parseUrl();
    // xử lý controller
    if (!empty($url[0])) {
      if (file_exists("./app/controllers/frontend/" . strtolower($url[0]) . ".php")) {
        $this->controller = $url[0];
        require "./app/controllers/frontend/" . $this->controller . ".php";
      } else if (file_exists("./app/controllers/backend/" . strtolower($url[0]) . ".php")) {
        $this->controller = $url[0];
        require "./app/controllers/backend/" . $this->controller . ".php";
      } else {
        require "./app/controllers/frontend/" . $this->controller . ".php";
      }
    } else {
      require "./app/controllers/frontend/" . $this->controller . ".php";
    }
    unset($url[0]);
    // xử lý action
    if (isset($url[1])) {
      $url[1] = strtolower($url[1]);
      if (method_exists($this->controller, $url[1])) {
        $this->action = $url[1];
        unset($url[1]);
      }
    }
    // Xử lý params
    $this->params = (count($url) > 0) ? $url : ["home"];

    
    call_user_func_array([new $this->controller, $this->action], $this->params);



  }

  private function parseUrl()
  {
    if (isset($_GET['url'])) {
      $url = $_GET['url'];
    } else {
      $url = "home";
    }
    // cắt chuỗi thành 1 mảng các phần tử được cắt bởi dấu /
    // và loại bỏ dấu / ở đầu cuối URL
    // filter_var loại bỏ ký tự đặc biệt trong url
    return explode("/", filter_var(trim($url, "/")), FILTER_SANITIZE_URL);
  }


}



?>