<?php
class AdminRoleDetailModel extends Database
{
  function insert($role_id, $module_id, $action)
  {
    $query = 'INSERT INTO role_detail (role_id, module_id, action) VALUES (?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$role_id, $module_id, $action]);
    // Check if the insert was successful (affected rows)
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      return true;
    } else {
      return false;
    }
  }

  function checkRoleDetail($role_id, $module_name, $action)
  {
    $query = '
    SELECT role_detail.*
    FROM role_detail
    JOIN role ON role_detail.role_id = role.id
    JOIN module ON role_detail.module_id = module.id
    WHERE role.id = ?
    AND module.name = ?
    AND role_detail.action = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$role_id, $module_name, $action]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      return true;
    } else {
      return false;
    }
  }
}