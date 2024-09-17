<?php
class AdminRole extends Controller
{
  function index()
  {
    $user = $this->model("admin/AdminUserModel");
    $user_data = $user->check_login();
    $data['modules'] = $user->check_role($user_data->role_id);
    if (!is_null($user_data)) {
      $data['page_title'] = "Admin - Role";
      $data['user_data'] = $user_data;
      $this->view("admin/AdminRole", $data);
    } else {
      $data['page_title'] = "Admin - Login";
      $this->view("admin/AdminLogin", $data);
    }
  }

  function getAllRoleToSelect()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->getAllRoleToSelect($_POST);
    }
  }

  function insert()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->insert($_POST);
      $latestRole = $role->getLatestRole();
      $selectedPermissions = $_POST['selectedPermissions'];
      $roleDetail = $this->model("admin/AdminRoleDetailModel");
      foreach ($selectedPermissions as $permission) {
        $moduleID = $permission['moduleID'];
        $functionName = $permission['functionName'];
        $roleDetail->insert($latestRole->id, $moduleID, $functionName);
      }
    }
  }

  function checkDuplicate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->checkDuplicate($_POST);
    }
  }

  function getAllRole()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->getAllRole();
    }
  }

  function deleteRole()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->deleteRole($_POST);
    }
  }

  function getDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role_id = $_POST['role_id'];
      $role->get_detail($role_id);
    }
  }

  function deleteRoleDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      $role->deleteRoleDetail($_POST);
    }
  }

  function update()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $role = $this->model("admin/AdminRoleModel");
      if ($role->deleteRoleDetail($_POST) == "Xóa thành công") {
        $role_id = $_POST['id'];
        $selectedPermissions = $_POST['selectedPermissions'];
        $roleDetail = $this->model("admin/AdminRoleDetailModel");
        foreach ($selectedPermissions as $permission) {
          $moduleID = $permission['moduleID'];
          $functionName = $permission['functionName'];
          // Insert each permission into the database
          $roleDetail->insert($role_id, $moduleID, $functionName);
        }
        echo "Sửa thành công";
      }
    }
  }

}
?>