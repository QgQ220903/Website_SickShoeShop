<?php
class AdminUser extends Controller
{
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);

    $module_name = "Người Dùng" ?: (in_array("Người Dùng", array_column($data['modules'], 'module_name')) ? "Người Dùng" : "");
    $role_detail = $this->model("admin/AdminRoleDetailModel");
    $add_btn = $role_detail->checkRoleDetail($user_data->role_id, $module_name, " Thêm ");
    $edit_btn = $role_detail->checkRoleDetail($user_data->role_id, $module_name, " Sửa ");
    $delete_btn = $role_detail->checkRoleDetail($user_data->role_id, $module_name, " Xóa ");
    $detail_btn = $role_detail->checkRoleDetail($user_data->role_id, $module_name, " Xem ");

    $data['add_btn'] = $add_btn;
    $data['edit_btn'] = $edit_btn;
    $data['delete_btn'] = $delete_btn;
    $data['detail_btn'] = $detail_btn;


    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - User";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminUser", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }

  }

  function change_page($page_number)
  {
    $model = $this->model("admin/AdminUserModel");
    $user_data = $model->check_login();
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - User";
      $data['user_data'] = $user_data;
      $data['users'] = $model->get_all();
      $data['numpage'] = $model->get_numpage();
      $this->view("admin/AdminUser", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }

  }

  function getAll()
  {
    $user = $this->model("admin/AdminUserModel");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user->getAll();
    }
  }

  function getByID()
  {
    $user = $this->model("admin/AdminUserModel");
    if (isset($_POST['id'])) {
      $user_id = $_POST['id'];
      $user->getByID($user_id);
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      $user->checkDuplicate($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      $user->update($_POST);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      $user->insert($_POST);
    }
  }
  function getAllUserForOption()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      if (isset($_POST['user_id'])) {
        $user->getAllUserForOption($_POST['user_id']);
      } else {
        $user->getAllUserForOption(0);
      }
    }
  }

  function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['deleteSend'];
      $user = $this->model("admin/AdminUserModel");
      $user->delete($id);
    }
  }

  function search()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $keyword = $_POST['keyword'];
      $user = $this->model("admin/AdminUserModel");
      $user->search($keyword);
    }
  }

  function saveAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $address = $this->model("admin/AdminAddressModel");
      $address->insert($_POST);
    }
  }
  function getAddressByUserID()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $address = $this->model("admin/AdminAddressModel");
      $user_id = $_POST['user_id'];
      $address->getAddressByUserID($user_id);
    }
  }

  function changeAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $address = $this->model("admin/AdminAddressModel");
      $address->update($_POST);
    }
  }

  function changeStatus()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $this->model("admin/AdminUserModel");
      $user->changeStatus($_POST);
    }
  }
}
?>