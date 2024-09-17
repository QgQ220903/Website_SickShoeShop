<?php class WardModel extends Database
{
  function getAllWard($POST)
  {
    $districtID = $POST['district_id'];
    $display = "";
    $sql = "SELECT * FROM ward where district_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$districtID]);
    $wards = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "
        <option value='0'>Chọn phường xã</option>
        ";
    foreach ($wards as $ward) {
      $display .= "
        <option value='{$ward->id}'>{$ward->name}</option>
        ";
    }
    echo $display;
  }

  function getAllWards()
  {
    $display = "";
    $sql = "SELECT * FROM ward";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $wards = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "
        <option value='0'>Chọn phường xã</option>
        ";
    foreach ($wards as $ward) {
      $display .= "
        <option value='{$ward->id}'>{$ward->name}</option>
        ";
    }
    echo $display;
  }

}