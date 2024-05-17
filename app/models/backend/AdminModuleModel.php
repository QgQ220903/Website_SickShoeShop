<?php
class AdminModuleModel extends Database
{
  function getAllModule()
  {
    $query = 'SELECT * FROM module';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $modules = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "";
    foreach ($modules as $module) {
      $display .= "
      <tr id=''>
        <input type='hidden' id='hidden_data' value = '{$module->id}'>
        <td scope='row'>{$module->name}</td>
        <td><input class='action_check' value= 'Thêm' type='checkbox' name='{$module->id} - {$module->name} - Thêm' id=''></td>
        <td><input class='action_check' value = 'Sửa' type='checkbox' name='{$module->id} - {$module->name} - Sửa' id=''></td>
        <td><input class='action_check' value = 'Xóa' type='checkbox' name='{$module->id} - {$module->name} - Xóa' id=''></td>
        <td><input class='action_check' value = 'Xem' type='checkbox' name='{$module->id} - {$module->name} - Xem' id=''></td>
        <td><input class='action_check' value = 'Import' type='checkbox' name='{$module->id} - {$module->name} - Import' id=''></td>
        <td><input class='action_check' value = 'Export' type='checkbox' name='{$module->id} - {$module->name} - Export' id=''></td>
      </tr>
      ";
    }
    echo $display;
  }
}