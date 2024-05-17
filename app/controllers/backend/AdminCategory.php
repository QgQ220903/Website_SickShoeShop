<?php
class AdminCategory extends Controller
{
  function index()
  {
    $user = $this->model("backend/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Category";
      $data['user_data'] = $user_data;
      $this->view("backend/AdminCategory", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("backend/AdminLogin", $data);
    }
  }

  // lấy toàn bộ thể loại (có phân trang)
  function getAll()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = $this->model("backend/AdminCategoryModel");
      $category->getAll();
    }
  }

  // lấy toàn bộ thể loại không phân trang
  function getAllCategories($category_id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = $this->model('backend/AdminCategoryModel');
      if (isset($_POST['category_id'])) {
        $category->getAllCategories($_POST['category_id']);
      } else {
        $category->getAllCategories(0);
      }
    }
  }

  // tìm kiếm (có phân trang)
  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $category = $this->model("backend/AdminCategoryModel");
      $category->search($keyword);
    }
  }
  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = $this->model("backend/AdminCategoryModel");
      $category->insert($_POST);
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = $this->model("backend/AdminCategoryModel");
      $category->checkDuplicate($_POST);
    }
  }

  function delete()
  {

    if (isset($_POST['deleteSend'])) {
      $id = $_POST['deleteSend'];
      $category = $this->model("backend/AdminCategoryModel");
      $category->delete($id);
    }
  }

  function getByID($id)
  {
    $category = $this->model("backend/AdminCategoryModel");
    if (isset($_POST['id'])) {
      $category_id = $_POST['id'];
      $category->getByID($category_id);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = $this->model("backend/AdminCategoryModel");
      $category->update($_POST);
    }
  }
}
?>