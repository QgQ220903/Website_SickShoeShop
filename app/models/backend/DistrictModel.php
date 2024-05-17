<?php class DistrictModel extends Database
{
  function getAllDistrict($POST)
  {
    $provinceID = $POST['province_id'];
    $display = "";
    $sql = "SELECT * FROM district where province_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$provinceID]);
    $districts = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "
      <option value='0'>Chọn quận huyện</option>
      ";
    foreach ($districts as $district) {
      $display .= "
      <option value='{$district->id}'>{$district->name}</option>
      ";
    }
    echo $display;
  }

  function getAllDistricts()
  {
    $display = "";
    $sql = "SELECT * FROM district";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $districts = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "
      <option value='0'>Chọn quận huyện</option>
      ";
    foreach ($districts as $district) {
      $display .= "
      <option value='{$district->id}'>{$district->name}</option>
      ";
    }
    echo $display;
  }
}