<?php
class AdminAddressModel extends Database
{
  // kiểm tra trùng lặp
  function checkDuplicate($address, $ward_id, $district_id, $province_id)
  {
    $query = 'SELECT * FROM address WHERE street_name = ? and ward_id = ? and district_id = ? and province_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$address, $ward_id, $district_id, $province_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->id;
    } else {
      return -1;
    }
  }

  function getAddressByUserID($user_id)
  {
    $query = 'SELECT * FROM user_address WHERE user_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->address_id;
    } else {
      return -1;
    }
  }

  // lấy ra địa chỉ vừa thêm vào
  function getLatestAddress()
  {
    $query = "SELECT * FROM `address` ORDER BY id DESC LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $address = $stmt->fetch(PDO::FETCH_OBJ);
    if ($address) {
      return $address->id;
    } else {
      return -1;
    }

  }

  // thêm mới 1 bản ghi
  function insert($POST)
  {
    $address = $POST['address'];
    $ward_id = $POST['ward'];
    $district_id = $POST['district'];
    $province_id = $POST['province'];
    $address_id = $this->checkDuplicate($address, $ward_id, $district_id, $province_id);
    if ($address_id == -1) {
      $query = 'INSERT INTO `address` (street_name, ward_id, district_id, province_id) VALUES (?, ?, ?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$address, $ward_id, $district_id, $province_id]);
      $latestAddress_id = $this->getLatestAddress();
      $user_id = $POST['user_id'];
      $query = 'INSERT INTO `user_address` (user_id, address_id) VALUES (?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$user_id, $latestAddress_id]);
      echo $latestAddress_id;
    } else {
      $user_id = $POST['user_id'];
      $query = 'INSERT INTO `user_address` (user_id, address_id) VALUES (?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$user_id, $address_id]);
      echo $address_id;
    }
  }


  // thêm mới địa chỉ nhà cung cấp
  function insertSupplierAddress($POST)
  {
    $address = $POST['address'];
    $ward_id = $POST['ward'];
    $district_id = $POST['district'];
    $province_id = $POST['province'];
    $address_id = $this->checkDuplicate($address, $ward_id, $district_id, $province_id);
    if ($address_id == -1) {
      $query = 'INSERT INTO `address` (street_name, ward_id, district_id, province_id) VALUES (?, ?, ?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$address, $ward_id, $district_id, $province_id]);
      $latestAddress_id = $this->getLatestAddress();
      echo $latestAddress_id;
    } else {
      echo $address_id;
    }
  }

  function update($POST)
  {
    $address = $POST['address'];
    $ward_id = $POST['ward'];
    $district_id = $POST['district'];
    $province_id = $POST['province'];
    $address_id = $this->checkDuplicate($address, $ward_id, $district_id, $province_id);
    if ($address_id == -1) {
      $query = 'INSERT INTO `address` (street_name, ward_id, district_id, province_id) VALUES (?, ?, ?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$address, $ward_id, $district_id, $province_id]);
      $latestAddress_id = $this->getLatestAddress();
      $user_id = $POST['user_id'];
      $query = 'UPDATE `user_address` SET address_id = ? where user_id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$latestAddress_id, $user_id]);
    } else {
      $user_id = $POST['user_id'];
      $query = 'UPDATE `user_address` SET address_id = ? where user_id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$address_id, $user_id]);
    }
  }
}