<?php class ProvinceModel extends Database
{
  public function getAllProvinces()
  {
    $display = "";
    $sql = "SELECT * FROM province";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $provinces = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "
      <option value='0'>Chọn tỉnh thành</option>
      ";
    foreach ($provinces as $province) {
      $display .= "
      <option value='{$province->id}'>{$province->name}</option>
      ";
    }
    echo $display;
  }

}