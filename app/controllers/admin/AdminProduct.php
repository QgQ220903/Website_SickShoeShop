<?php
class AdminProduct extends Controller
{
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminProduct", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function add()
  {

    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Add Product";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminAddProduct", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->getAll();
    }
  }

  function getAllProduct()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->getAllProduct();
    }
  }

  function getAllProductBySupplierName()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->getAllProductBySupplierName($_POST['supplier_name']);
    }
  }

  function getAllProductForSelect()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->getAllProductForSelect();
    }
  }

  // tìm kiếm các bản ghi dựa trên từ khóa liên quan
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $product = $this->model("admin/AdminProductModel");
      $product->search($keyword);
    }
  }
  function searchProductForSelect()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $product = $this->model("admin/AdminProductModel");
      $product->searchProductForSelect($keyword);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->insert($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $this->model("admin/AdminProductModel");
      $product->update($_POST);
    }
  }

  // xóa 1 sản phẩm
  function delete()
  {
    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $product = $this->model("admin/AdminProductModel");
      $product->delete($id);
    }
  }

  function getDetail($id)
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    if (!is_null($user_data)) {
      $data['modules'] = $user->check_role($user_data->role_id);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
    $productModel = $this->model("admin/AdminProductModel");
    $productData = $productModel->getByID($id);
    $data['page_title'] = "Admin - Product Form";
    $data['product'] = $productData;
    $this->view("admin/AdminUpdateProduct", $data);
  }

  function productDetail($id)
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Product";
      $data['user_data'] = $user_data;
      $productModel = $this->model("admin/AdminProductModel");
      $productData = $productModel->getByID($id);
      $data['page_title'] = "Admin - Product Form";
      $data['product'] = $productData;
      $this->view("admin/AdminProductDetail", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }

  }
}
?>